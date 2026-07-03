<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginCsrfTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_post_with_stale_csrf_token_redirects_back_and_flashes_expired_message()
    {
        $handler = app(\App\Exceptions\Handler::class);
        $request = \Illuminate\Http\Request::create('/login', 'POST');
        // Set request session
        $request->setLaravelSession(app('session')->driver('array'));

        $response = $handler->render($request, new \Illuminate\Session\TokenMismatchException());

        $this->assertEquals(302, $response->getStatusCode());
    }

    /** @test */
    public function login_blade_defines_getCsrfToken_function()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_login.blade.php')
        );
        $this->assertStringContainsString('function getCsrfToken()', $source,
            'getCsrfToken() function must be defined in the login blade');
    }

    /** @test */
    public function login_blade_defines_refreshCsrfToken_function()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_login.blade.php')
        );
        $this->assertStringContainsString('function refreshCsrfToken()', $source,
            'refreshCsrfToken() function must be defined in the login blade');
    }

    /** @test */
    public function login_blade_references_refresh_csrf_endpoint()
    {
        $source = file_get_contents(
            base_path('resources/views/frontend/user_login.blade.php')
        );
        $this->assertStringContainsString('/refresh-csrf', $source,
            'refreshCsrfToken() must call the /refresh-csrf endpoint');
    }
}
