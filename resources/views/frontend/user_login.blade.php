@extends('frontend.layouts.app')

@section('content')
<style>
    .login-method-tabs {
        display: flex;
        gap: 6px;
        padding: 6px;
        border: 1px solid #e9ecef;
        border-radius: 30px;
        background: #f8f9fa;
    }
    .login-method-tab {
        flex: 1;
        border: 0;
        border-radius: 24px;
        padding: 10px 16px;
        background: transparent;
        color: #495057;
        font-weight: 600;
        cursor: pointer;
    }
    .login-method-tab.active {
        color: #fff;
        background: linear-gradient(135deg, var(--primary, #FD2C79), var(--secondary, #FD655B));
    }
</style>
<div class="py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-md-7 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <h1 class="h3 text-primary mb-0">{{ translate('Login to your account') }}</h1>
                        </div>

                        <form class="" method="POST" action="{{ route('login') }}">
                            @csrf
                            @php
                                $oldLoginValue = old('email');
                                $oldMethod = empty($oldLoginValue) || filter_var($oldLoginValue, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
                            @endphp
                            <input type="hidden" name="email" id="email" value="{{ $oldLoginValue }}">
                            <input type="hidden" name="country_code" value="{{ old('country_code', '91') }}">

                            <div class="form-group mb-3">
                                <div class="login-method-tabs">
                                    <button type="button" class="login-method-tab {{ $oldMethod == 'email' ? 'active' : '' }}" id="login-tab-email" onclick="switchLoginMethod('email')">
                                        {{ translate('Email') }}
                                    </button>
                                    <button type="button" class="login-method-tab {{ $oldMethod == 'phone' ? 'active' : '' }}" id="login-tab-phone" onclick="switchLoginMethod('phone')">
                                        {{ translate('Phone') }}
                                    </button>
                                </div>
                            </div>

                            <div class="form-group" id="email-login-wrapper">
                                <label class="form-label" for="login-email">
                                    {{ translate('Email Address') }}
                                </label>
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $oldMethod == 'email' ? $oldLoginValue : '' }}" placeholder="{{ translate('Enter email address')}}" id="login-email">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="opacity-60">{{ translate('Enter your email address') }}</span>
                            </div>

                            <div class="form-group" id="phone-login-wrapper">
                                <label class="form-label" for="login-phone">
                                    {{ translate('Phone Number') }}
                                </label>
                                <input type="tel" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ $oldMethod == 'phone' ? $oldLoginValue : '' }}" placeholder="{{ translate('Enter phone number')}}" id="login-phone">
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <span class="opacity-60">{{ translate('Enter your phone number') }}</span>
                            </div>

                            <div class="form-group mb-3">
                                <label class="form-label" for="password">{{ translate('Password') }}</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********" required>
                                    <span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                                        <i class="las la-eye" id="togglePasswordIcon"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3 text-right">
                                <a class="link-muted text-capitalize font-weight-normal" href="{{ route('password.request') }}">{{ translate('Forgot Password?') }}</a>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-block btn-primary">{{ translate('Login to your Account') }}</button>
                            </div>
                        </form>
                        @if (env("DEMO_MODE") == "On")
                            <div class="mb-5">
                                <table class="table table-bordered table-responsive">
                                    <tbody>
                                        <tr>
                                            <td>user2@example.com</td>
                                            <td>12345678</td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary btn-xs" onclick="autoFill1()">{{ translate('Copy credentials') }}</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>user17@example.com</td>
                                            <td>12345678</td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary btn-xs" onclick="autoFill2()">{{ translate('Copy credentials') }}</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        @if(get_setting('google_login_activation') == 1 || get_setting('facebook_login_activation') == 1 || get_setting('twitter_login_activation') == 1 || get_setting('apple_login_activation') == 1)
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60">{{ translate('Or Login With')}}</span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                @if (get_setting('facebook_login_activation') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(get_setting('google_login_activation') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'google']) }}" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('twitter_login_activation') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                                @if (get_setting('apple_login_activation') == 1)
                                    <li class="list-inline-item">
                                        <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="apple">
                                            <i class="lab la-apple"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                        <div class="text-center">
                            <p class="text-muted mb-0">{{ translate("Don't have an account?") }}</p>
                            <a href="{{ route('register') }}">{{ translate('Create an account') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
	<script>
    var $ = window.jQuery || jQuery;
    var loginMethod = '{{ $oldMethod }}';
    var phoneInputInstance = null;

    $(document).ready(function() {
        var phoneInput = document.querySelector("#login-phone");

        if (phoneInput && typeof window.intlTelInputGlobals !== 'undefined') {
            phoneInputInstance = intlTelInput(phoneInput, {
                initialCountry: "in",
                separateDialCode: true,
                utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
                onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
            });
            phoneInput.addEventListener("countrychange", updateCountryCode);
        }

        switchLoginMethod(loginMethod);

        $('form').on('submit', function() {
            syncLoginValue();
        });
    });

    function switchLoginMethod(method) {
        loginMethod = method;
        $('.login-method-tab').removeClass('active');
        $('#login-tab-' + method).addClass('active');

        if (method === 'email') {
            $('#email-login-wrapper').show();
            $('#phone-login-wrapper').hide();
            $('#login-email').prop('required', true);
            $('#login-phone').prop('required', false);
        } else {
            $('#email-login-wrapper').hide();
            $('#phone-login-wrapper').show();
            $('#login-email').prop('required', false);
            $('#login-phone').prop('required', true);
            updateCountryCode();
        }

        syncLoginValue();
    }

    function updateCountryCode() {
        if (!phoneInputInstance) {
            $('input[name=country_code]').val('91');
            return;
        }

        var country = phoneInputInstance.getSelectedCountryData();
        $('input[name=country_code]').val(country.dialCode || '91');
    }

    function syncLoginValue() {
        if (loginMethod === 'email') {
            $('#email').val($('#login-email').val());
        } else {
            $('#email').val($('#login-phone').val());
            updateCountryCode();
        }
    }

    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');
        const isPasswordVisible = passwordInput.type === 'text';

        passwordInput.type = isPasswordVisible ? 'password' : 'text';
        toggleIcon.classList.toggle('la-eye');
        toggleIcon.classList.toggle('la-eye-slash');
    }


</script>

@endsection