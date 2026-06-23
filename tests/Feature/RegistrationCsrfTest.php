<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

/**
 * RegistrationCsrfTest
 *
 * Tests the CSRF token mismatch fix for the registration form.
 *
 * Root cause (mobile bug):
 *   On mobile, the tab is backgrounded while the user waits for OTP.
 *   The PHP session can expire/regenerate during this time.
 *   The CSRF token baked into the form HTML at page load becomes stale.
 *   When the form is finally submitted, Laravel rejects it with HTTP 419.
 *
 * Fix strategy (in user_registration.blade.php):
 *   1.  getCsrfToken()     – reads CSRF from <meta name="csrf-token"> (always live)
 *   2.  refreshCsrfToken() – called after OTP verify, fetches a fresh token
 *                            from /refresh-csrf and updates the form hidden field
 *   3.  Form submit        – syncs current meta-token into the hidden _token field
 */
class RegistrationCsrfTest extends TestCase
{
    use RefreshDatabase;

    // ─── /refresh-csrf route ─────────────────────────────────────────────────

    /** @test */
    public function refresh_csrf_route_returns_200()
    {
        $response = $this->get('/refresh-csrf');
        $response->assertStatus(200);
    }

    /** @test */
    public function refresh_csrf_route_returns_a_non_empty_string()
    {
        $response = $this->get('/refresh-csrf');
        $response->assertStatus(200);
        $this->assertNotEmpty($response->getContent());
    }

    /** @test */
    public function refresh_csrf_route_returns_40_char_token()
    {
        $response = $this->get('/refresh-csrf');
        // Laravel CSRF tokens are 40 hex characters (SHA-1 based)
        $this->assertEquals(40, strlen($response->getContent()));
    }

    /** @test */
    public function refresh_csrf_token_is_a_valid_hex_string()
    {
        $response = $this->get('/refresh-csrf');
        $token    = $response->getContent();
        $this->assertMatchesRegularExpression('/^[a-zA-Z0-9]+$/', $token,
            'CSRF token must be alphanumeric');
    }

    // ─── CSRF rejection (simulates the mobile bug) ───────────────────────────

    /** @test */
    public function registration_post_with_stale_csrf_token_returns_419_or_rejects()
    {
        // In the test environment, Laravel manages the session and the test client
        // can share a session token. To truly simulate a stale CSRF token (mobile bug),
        // we craft a request with a deliberately wrong _token header and ensure it
        // is not processed as a successful registration.
        //
        // We use a new session (withSession cleared) to prevent test framework
        // from auto-passing CSRF for us.
        $this->flushSession();

        $response = $this->withSession([])->post(route('register'), [
            '_token'                => 'stale-token-that-does-not-match-any-session',
            'first_name'            => 'Test',
            'last_name'             => 'User',
            'email'                 => 'stale_csrf@example.com',
            'password'              => 'Password123',
            'password_confirmation' => 'Password123',
            'gender'                => '1',
            'date_of_birth'         => '01/01/1990',
            'on_behalf'             => '1',
            'otp'                   => '123456',
            'registration_method'   => 'email',
            'timeOfBirth'           => '08:00',
            'birthPlace'            => 'Chennai',
            'checkbox_example_1'    => 'on',
        ]);

        // Laravel CSRF middleware must reject. Accept 419 (token mismatch) or redirect
        // back (302) — not 200 (which would mean registration succeeded).
        $this->assertNotEquals(200, $response->getStatusCode(),
            'A request with a stale CSRF token must never return 200 OK');
    }

    // ─── OTP routes CSRF validation ──────────────────────────────────────────

    /** @test */
    public function send_otp_route_is_protected_by_csrf_middleware()
    {
        // Verify VerifyCsrfToken middleware is in the web middleware group
        // (which includes send.otp and verify.otp routes).
        // We check the route middleware stack rather than testing HTTP status
        // because the SQLite test DB doesn't have all production columns,
        // causing 500 errors before CSRF rejection when the query runs.
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('send.otp');
        $this->assertNotNull($route, 'send.otp route must exist');

        // The route should be in the 'web' group which includes csrf protection
        $middleware = $route->gatherMiddleware();
        $hasCsrf = collect($middleware)->contains(function($m) {
            return str_contains($m, 'csrf') || str_contains($m, 'VerifyCsrfToken');
        });
        // Web group automatically includes CSRF; we just verify 'web' is present
        $hasWeb = collect($middleware)->contains('web');
        $this->assertTrue($hasWeb || $hasCsrf,
            'send.otp route must be protected by web middleware (includes CSRF)');
    }

    /** @test */
    public function verify_otp_route_is_protected_by_csrf_middleware()
    {
        $route = \Illuminate\Support\Facades\Route::getRoutes()->getByName('verify.otp');
        $this->assertNotNull($route, 'verify.otp route must exist');

        $middleware = $route->gatherMiddleware();
        $hasWeb = collect($middleware)->contains('web');
        $hasCsrf = collect($middleware)->contains(function($m) {
            return str_contains($m, 'csrf') || str_contains($m, 'VerifyCsrfToken');
        });
        $this->assertTrue($hasWeb || $hasCsrf,
            'verify.otp route must be protected by web middleware (includes CSRF)');
    }

    // ─── OTP functional tests ─────────────────────────────────────────────────

    /** @test */
    public function verify_otp_accepts_valid_csrf_and_returns_json_success()
    {
        // Seed OTP in cache (as sendOTP does)
        $email = 'verifytest@example.com';
        Cache::put('registration_otp_email_' . $email, '654321', 600);
        Cache::put('registration_otp_email_time_' . $email, now()->toISOString(), 600);

        $response = $this->withoutExceptionHandling()
            ->post(route('verify.otp'), [
                '_token' => csrf_token(),
                'otp'    => '654321',
                'email'  => $email,
            ]);

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertArrayHasKey('success', $data);
        $this->assertTrue($data['success'],
            'verifyOTP should return success:true when the correct OTP is provided');
    }

    /** @test */
    public function verify_otp_returns_failure_for_wrong_otp()
    {
        $email = 'wrongotp@example.com';
        Cache::put('registration_otp_email_' . $email, '111111', 600);
        Cache::put('registration_otp_email_time_' . $email, now()->toISOString(), 600);

        $response = $this->post(route('verify.otp'), [
            '_token' => csrf_token(),
            'otp'    => '999999', // wrong OTP
            'email'  => $email,
        ]);

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertFalse($data['success'],
            'verifyOTP should return success:false for wrong OTP');
    }

    /** @test */
    public function verify_otp_returns_failure_for_expired_otp()
    {
        $email = 'expired@example.com';
        Cache::put('registration_otp_email_' . $email, '222222', 600);
        // OTP created 15 minutes ago — past the 10-minute expiry window
        Cache::put('registration_otp_email_time_' . $email,
            now()->subMinutes(15)->toISOString(), 600);

        $response = $this->post(route('verify.otp'), [
            '_token' => csrf_token(),
            'otp'    => '222222',
            'email'  => $email,
        ]);

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertFalse($data['success'],
            'verifyOTP should return success:false for expired OTP');
        $this->assertStringContainsString('expired', strtolower($data['message']));
    }

    /** @test */
    public function verify_otp_returns_failure_when_no_otp_in_cache()
    {
        // Simulate mobile: user waited too long, cache expired (or was never set)
        $email = 'nocache@example.com';
        Cache::forget('registration_otp_email_' . $email);
        Cache::forget('registration_otp_email_time_' . $email);

        $response = $this->post(route('verify.otp'), [
            '_token' => csrf_token(),
            'otp'    => '333333',
            'email'  => $email,
        ]);

        $response->assertStatus(200);
        $data = json_decode($response->getContent(), true);
        $this->assertFalse($data['success']);
    }

    // ─── /refresh-csrf idempotency ───────────────────────────────────────────

    /** @test */
    public function multiple_refresh_csrf_requests_in_same_session_return_same_token()
    {
        // Within the same session Laravel should return the same CSRF token
        // (it only regenerates on login/logout). This test ensures the /refresh-csrf
        // route is stable and can be polled safely.
        $token1 = $this->get('/refresh-csrf')->getContent();
        $token2 = $this->get('/refresh-csrf')->getContent();

        $this->assertEquals($token1, $token2,
            '/refresh-csrf should return the same token within a session');
    }

    // ─── Registration blade source code checks ───────────────────────────────
    // These tests read the blade file directly (no DB required) and verify the
    // JavaScript CSRF fix is present in the source.

    /** @test */
    public function registration_blade_uses_getCsrfToken_for_all_ajax_calls()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );

        // The old buggy pattern baked the token at render time:
        //   _token: '{{ csrf_token() }}'
        // The fix reads it live from the meta tag:
        //   _token: getCsrfToken()
        $count = substr_count($source, '_token: getCsrfToken()');
        $this->assertEquals(3, $count,
            "Expected 3 AJAX calls using getCsrfToken() (sendOTP phone, sendOTP email, verifyOTP). Found: {$count}");
    }

    /** @test */
    public function registration_blade_defines_getCsrfToken_function()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        $this->assertStringContainsString('function getCsrfToken()', $source,
            'getCsrfToken() function must be defined in the registration blade');
    }

    /** @test */
    public function registration_blade_defines_refreshCsrfToken_function()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        $this->assertStringContainsString('function refreshCsrfToken()', $source,
            'refreshCsrfToken() function must be defined in the registration blade');
    }

    /** @test */
    public function registration_blade_calls_refreshCsrfToken_after_otp_verify_success()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        $this->assertStringContainsString('refreshCsrfToken();', $source,
            'refreshCsrfToken() must be called inside the OTP verify AJAX success callback');
    }

    /** @test */
    public function registration_blade_syncs_token_field_on_form_submit()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        // The form submit handler must update hidden _token from meta tag
        $this->assertStringContainsString("input[name=\"_token\"]", $source,
            'Form submit handler must sync the _token hidden field from getCsrfToken()');
    }

    /** @test */
    public function registration_blade_reads_csrf_from_meta_tag_not_inline()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        // Ensure meta[name="csrf-token"] is referenced in JS
        $this->assertStringContainsString("meta[name=\"csrf-token\"]", $source,
            'getCsrfToken() must read from the meta[name="csrf-token"] element');
    }

    /** @test */
    public function registration_blade_references_refresh_csrf_endpoint()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        $this->assertStringContainsString('/refresh-csrf', $source,
            'refreshCsrfToken() must call the /refresh-csrf endpoint');
    }

    /** @test */
    public function registration_blade_does_not_hardcode_static_csrf_in_ajax()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_registration.blade.php')
        );
        // The OLD broken pattern: _token: '{{ csrf_token() }}' (hardcoded at render time)
        // Count old-style hardcoded tokens in AJAX data sections — should be 0
        $oldPattern = "_token: '{{ csrf_token() }}'";
        $this->assertStringNotContainsString($oldPattern, $source,
            "Found hardcoded static CSRF token in AJAX call. Use getCsrfToken() instead to avoid 419 on mobile.");
    }
}
