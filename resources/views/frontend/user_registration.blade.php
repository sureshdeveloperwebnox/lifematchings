@extends('frontend.layouts.app')

@section('content')
<style>
	.otp-segmented-control {
		display: flex;
		background: #f8f9fa;
		padding: 6px;
		border-radius: 30px;
		position: relative;
		border: 1px solid #e9ecef;
		box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.04);
	}
	.otp-segment-btn {
		flex: 1;
		border: none;
		background: transparent;
		padding: 12px 20px;
		border-radius: 26px;
		font-size: 14px;
		font-weight: 600;
		color: #495057;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		cursor: pointer;
	}
	.otp-segment-btn i {
		font-size: 18px;
	}
	.otp-segment-btn.active {
		background: linear-gradient(135deg, var(--primary, #FD2C79) 0%, var(--secondary, #FD655B) 100%);
		color: #fff !important;
		box-shadow: 0 4px 15px rgba(253, 44, 121, 0.35);
	}
	.otp-segment-btn:hover:not(.active) {
		background: rgba(0, 0, 0, 0.04);
		color: #212529;
	}
</style>
<div class="py-4 py-lg-5">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">
				<div class="card">
					<div class="card-body">

						<div class="mb-5 text-center">
							<h1 class="h3 text-primary mb-0">{{ translate('Create Your Account') }}</h1>
							<p>{{ translate('Fill out the form to get started') }}.</p>
						</div>
						<form class="form-default" id="reg-form" role="form" action="{{ route('register') }}" method="POST">
							@csrf
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="on_behalf">{{ translate('On Behalf') }}</label>
										@php $on_behalves = \App\Models\OnBehalf::all(); @endphp
										<select class="form-control aiz-selectpicker @error('on_behalf') is-invalid @enderror" name="on_behalf" required>
											@foreach ($on_behalves as $on_behalf)
												<option value="{{$on_behalf->id}}">{{$on_behalf->name}}</option>
											@endforeach
										</select>
										@error('on_behalf')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="row">
						        <div class="col-lg-6">
						            <div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('First Name') }}</label>
										<input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" id="first_name" placeholder="{{translate('First Name')}}"  required>
										@error('first_name')
											<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
						            </div>
						        </div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('Last Name') }}</label>
										<input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" id="last_name" placeholder="{{ translate('Last Name') }}"  required>
										@error('last_name')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
    						</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="gender">{{ translate('Gender') }}</label>
										<select class="form-control aiz-selectpicker @error('gender') is-invalid @enderror" name="gender" required>
											<option value="1">{{translate('Male')}}</option>
											<option value="2">{{translate('Female')}}</option>
										</select>
										@error('gender')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name">{{ translate('Date Of Birth') }}</label>
										<input type="text" class="form-control aiz-date-range @error('date_of_birth') is-invalid @enderror" name="date_of_birth" id="date_of_birth" placeholder="{{ translate('Date Of Birth') }}" data-single="true" data-show-dropdown="true" data-max-date="{{ get_max_date() }}" autocomplete="off" required>
										@error('date_of_birth')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="timeOfBirth">{{ translate('Time Of Birth') }}</label>
										<input type="time" class="form-control @error('timeOfBirth') is-invalid @enderror" 
											name="timeOfBirth" id="timeOfBirth" 
											placeholder="{{ translate('HH:MM') }}" 
											required>
										@error('timeOfBirth')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="birthPlace">{{ translate('Birth Place') }}</label>
										<input type="text" class="form-control @error('birthPlace') is-invalid @enderror" name="birthPlace" id="birthPlace" placeholder="{{ translate('Birth Place') }}"  required>
										@error('birthPlace')
										<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>

							<!-- Segmented Control for OTP sending option -->
							<div class="row mb-3">
								<div class="col-lg-12">
									<div class="otp-segmented-control">
										<button type="button" class="otp-segment-btn active" id="segment-email" onclick="switchOtpTab('email')">
											<i class="las la-envelope"></i> {{ translate('Email Address') }}
										</button>
										<button type="button" class="otp-segment-btn" id="segment-phone" onclick="switchOtpTab('phone')">
											<i class="las la-phone"></i> {{ translate('Phone Number') }}
										</button>
									</div>
									<input type="hidden" name="registration_method" id="registration_method" value="{{ old('registration_method', 'email') }}">
								</div>
							</div>

							<!-- Email address field -->
							<div class="row" id="email-field-wrapper">
								<div class="col-lg-12">
								  <div class="form-group mb-3">
										<label class="form-label" for="email">{{ translate('Email address') }}</label>
										<div class="d-flex">
											<input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="signinSrEmail" placeholder="{{ translate('Email Address') }}" value="{{ old('email') }}">
											<button type="button" class="btn btn-outline-primary flex-shrink-0 ms-2" id="send-email-otp-btn" onclick="sendEmailOTP()">{{ translate('Send OTP') }}</button>
										</div>
								        @error('email')
								            <span class="invalid-feedback" role="alert">{{ $message }}</span>
								        @enderror
								  </div>
								</div>
							</div>

							<!-- Phone number field -->
							<div class="row" id="phone-field-wrapper" style="display: none;">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="phone">{{ translate('Phone Number') }}</label>
										<div class="d-flex">
											<input type="tel" id="phone-code" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="{{ translate('Enter phone number') }}" name="phone" autocomplete="off">
											<button type="button" class="btn btn-outline-primary flex-shrink-0 ms-2" id="send-otp-btn" onclick="sendOTP()">{{ translate('Send OTP') }}</button>
										</div>
										@error('phone')
											<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
										<input type="hidden" name="country_code" value="">
									</div>
								</div>
							</div>
								

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="otp">{{ translate('OTP Verification') }}</label>
										<div class="input-group d-flex">
											<input type="text" class="form-control @error('otp') is-invalid @enderror" name="otp" id="otp" placeholder="{{ translate('Enter OTP') }}" maxlength="6" required>
											<button type="button" class="btn btn-outline-success flex-shrink-0" id="verify-otp-btn" onclick="verifyOTP()">{{ translate('Verify OTP') }}</button>
										</div>
										@error('otp')
											<span class="invalid-feedback" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="password">{{ translate('Password') }}</label>
										<div class="position-relative">
											<input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="********" aria-label="********" required>
											<span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password', this)" style="cursor: pointer;">
												<i class="las la-eye"></i>
											</span>
										</div>
										<small>{{ translate('Minimun 8 characters') }}</small>
										@error('password')
										<span class="invalid-feedback d-block" role="alert">{{ $message }}</span>
										@enderror
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="password-confirm">{{ translate('Confirm password') }}</label>
										<div class="position-relative">
											<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="********" required>
											<span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password_confirmation', this)" style="cursor: pointer;">
												<i class="las la-eye"></i>
											</span>
										</div>
										<small>{{ translate('Minimun 8 characters') }}</small>
									</div>
								</div>
							</div>

							@if(addon_activation('referral_system'))
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="email">{{ translate('Referral Code') }}</label>
										<input type="text" class="form-control{{ $errors->has('referral_code') ? ' is-invalid' : '' }}" value="{{ old('referral_code') }}" placeholder="{{  translate('Referral Code') }}" name="referral_code">
										@if ($errors->has('referral_code'))
											<span class="invalid-feedback" role="alert">
												<strong>{{ $errors->first('referral_code') }}</strong>
											</span>
										@endif
									</div>
								</div>
							</div>
							@endif

							@if(get_setting('google_recaptcha_activation') == 1)
							<div class="form-group">
								<div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_KEY') }}"></div>
								@error('g-recaptcha-response')
									<span class="invalid-feedback" role="alert">{{ $message }}</span>
								@enderror
							</div>
							@endif

							<div class="mb-3">
								<label class="aiz-checkbox">
								<input type="checkbox" name="checkbox_example_1" required>
									<span class=opacity-60>{{ translate('By signing up you agree to our')}}
										<a href="{{ env('APP_URL').'/terms-conditions' }}" target="_blank">{{ translate('terms and conditions')}}.</a>
									</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>
							@error('checkbox_example_1')
								<span class="invalid-feedback" role="alert">{{ $message }}</span>
							@enderror

							<div class="mb-5">
								<button type="submit" class="btn btn-block btn-primary">{{ translate('Create Account') }}</button>
							</div>
							{{-- @if(get_setting('google_login_activation') == 1 || get_setting('facebook_login_activation') == 1 || get_setting('twitter_login_activation') == 1 || get_setting('apple_login_activation') == 1)
			                <div class="mb-5">
			                    <div class="separator mb-3">
			                        <span class="bg-white px-3">{{ translate('Or Join With') }}</span>
			                    </div>
	                    		<ul class="list-inline social colored text-center">
									@if(get_setting('facebook_login_activation') == 1)
			                        <li class="list-inline-item">
			                            <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="facebook" title="{{ translate('Facebook') }}"><i class="lab la-facebook-f"></i></a>
			                        </li>
									@endif
									@if(get_setting('google_login_activation') == 1)
									<li class="list-inline-item">
										<a href="{{ route('social.login', ['provider' => 'google']) }}" class="google" title="{{ translate('Google') }}"><i class="lab la-google"></i></a>
									</li>
									@endif
									@if(get_setting('twitter_login_activation') == 1)
			                        <li class="list-inline-item">
			                            <a href="{{ route('social.login', ['provider' => 'twitter']) }}" class="twitter" title="{{ translate('Twitter') }}"><i class="lab la-twitter"></i></a>
			                        </li>
									@endif
									@if(get_setting('apple_login_activation') == 1)
			                        <li class="list-inline-item">
			                            <a href="{{ route('social.login', ['provider' => 'apple']) }}" class="apple" title="{{ translate('Apple') }}"><i class="lab la-apple"></i></a>
			                        </li>
									@endif
								</ul>
							</div>
							@endif --}}

							<div class="text-center">
								<p class="text-muted mb-0">{{ translate("Already have an account?") }}</p>
								<a href="{{ route('login') }}">{{ translate('Login to your account') }}</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection



@section('script')
	@if(get_setting('google_recaptcha_activation') == 1)
		@include('partials.recaptcha')
	@endif
	
	<script type="text/javascript">
		var $ = window.jQuery || jQuery;
		$(document).ready(function() {
			if (typeof window.intlTelInputGlobals === 'undefined') {
				var errorDiv = document.getElementById('js-debug-errors');
				if (errorDiv) {
					errorDiv.style.display = 'block';
					errorDiv.textContent += '\nError: intlTelInputGlobals is not defined. vendors.js might have failed to load or execute.';
				}
				return;
			}

			var isPhoneShown = true,
				countryData = window.intlTelInputGlobals.getCountryData(),
				input = document.querySelector("#phone-code");

			for (var i = 0; i < countryData.length; i++) {
				var country = countryData[i];
				if (country.iso2 == 'bd') {
					country.dialCode = '88';
				}
			}

			var iti = intlTelInput(input, {
				initialCountry: "auto",
				geoIpLookup: function(callback) {
					$.get('https://ipinfo.io', function() {}, "jsonp").always(function(resp) {
						var countryCode = (resp && resp.country) ? resp.country : "us";
						callback(countryCode);
					});
				},
				separateDialCode: true,
				utilsScript: "{{ static_asset('assets/js/intlTelutils.js') }}?1590403638580",
				onlyCountries: @php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) @endphp,
				customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
					if (selectedCountryData.iso2 == 'bd') {
						return "01xxxxxxxxx";
					}
					return selectedCountryPlaceholder;
				}
			});

			var country = iti.getSelectedCountryData();
			$('input[name=country_code]').val(country.dialCode);

			// Initialize tab based on old value or default to email
			var initialMethod = $('#registration_method').val() || 'email';
			switchOtpTab(initialMethod);

			input.addEventListener("countrychange", function(e) {
				var country = iti.getSelectedCountryData();
				$('input[name=country_code]').val(country.dialCode);
			});
		});

		function switchOtpTab(method) {
			$('#registration_method').val(method);
			$('.otp-segment-btn').removeClass('active');
			if (method === 'email') {
				$('#segment-email').addClass('active');
				$('#email-field-wrapper').show();
				$('#phone-field-wrapper').hide();
				$('#signinSrEmail').prop('required', true);
				$('#phone-code').prop('required', false);
			} else {
				$('#segment-phone').addClass('active');
				$('#email-field-wrapper').hide();
				$('#phone-field-wrapper').show();
				$('#signinSrEmail').prop('required', false);
				$('#phone-code').prop('required', true);
			}
		}

		function sendOTP() {
			var phone = $('#phone-code').val();
			var countryCode = $('input[name=country_code]').val();
			
			if (!phone) {
				AIZ.plugins.notify('warning', '{{ translate("Please enter phone number") }}');
				return;
			}
			
			$('#send-otp-btn').prop('disabled', true).text('{{ translate("Sending...") }}');
			
			$.ajax({
				url: '{{ route("send.otp") }}',
				type: 'POST',
				data: {
					phone: phone,
					country_code: countryCode,
					delivery_method: 'phone',
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					if (response.success) {
						AIZ.plugins.notify('success', 'OTP sent to your phone successfully!');
						$('#otp').focus();
						// Start 30 second countdown
						startOTPCountdown();
					} else {
						AIZ.plugins.notify('danger', response.message || 'Failed to send OTP');
						$('#send-otp-btn').prop('disabled', false).text('{{ translate("Send OTP") }}');
					}
				},
				error: function() {
					AIZ.plugins.notify('danger', 'Failed to send OTP');
					$('#send-otp-btn').prop('disabled', false).text('{{ translate("Send OTP") }}');
				}
			});
		}

		function startOTPCountdown() {
			var countdown = 30;
			var $btn = $('#send-otp-btn');
			
			$btn.prop('disabled', true);
			
			var timer = setInterval(function() {
				$btn.text('{{ translate("Resend OTP") }} (' + countdown + 's)');
				countdown--;
				
				if (countdown < 0) {
					clearInterval(timer);
					$btn.prop('disabled', false).text('{{ translate("Send OTP") }}');
				}
			}, 1000);
		}

		function sendEmailOTP() {
			var email = $('#signinSrEmail').val();
			
			if (!email) {
				AIZ.plugins.notify('warning', '{{ translate("Please enter email address") }}');
				$('#signinSrEmail').focus();
				return;
			}
			var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
			if (!emailReg.test(email)) {
				AIZ.plugins.notify('warning', '{{ translate("Please enter a valid email address") }}');
				$('#signinSrEmail').focus();
				return;
			}
			
			$('#send-email-otp-btn').prop('disabled', true).text('{{ translate("Sending...") }}');
			
			$.ajax({
				url: '{{ route("send.otp") }}',
				type: 'POST',
				data: {
					email: email,
					delivery_method: 'email',
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					if (response.success) {
						AIZ.plugins.notify('success', 'OTP sent to your email successfully!');
						$('#otp').focus();
						startEmailOTPCountdown();
					} else {
						AIZ.plugins.notify('danger', response.message || 'Failed to send OTP');
						$('#send-email-otp-btn').prop('disabled', false).text('{{ translate("Send OTP") }}');
					}
				},
				error: function() {
					AIZ.plugins.notify('danger', 'Failed to send OTP');
					$('#send-email-otp-btn').prop('disabled', false).text('{{ translate("Send OTP") }}');
				}
			});
		}

		function startEmailOTPCountdown() {
			var countdown = 30;
			var $btn = $('#send-email-otp-btn');
			
			$btn.prop('disabled', true);
			
			var timer = setInterval(function() {
				$btn.text('{{ translate("Resend OTP") }} (' + countdown + 's)');
				countdown--;
				
				if (countdown < 0) {
					clearInterval(timer);
					$btn.prop('disabled', false).text('{{ translate("Send OTP") }}');
				}
			}, 1000);
		}

		function verifyOTP() {
			var otp = $('#otp').val();
			
			if (!otp) {
				AIZ.plugins.notify('warning', '{{ translate("Please enter OTP") }}');
				return;
			}
			
			$('#verify-otp-btn').prop('disabled', true).text('{{ translate("Verifying...") }}');
			
			$.ajax({
				url: '{{ route("verify.otp") }}',
				type: 'POST',
				data: {
					otp: otp,
					_token: '{{ csrf_token() }}'
				},
				success: function(response) {
					if (response.success) {
						AIZ.plugins.notify('success', 'OTP verified successfully!');
						$('#otp').prop('readonly', true);
						$('#verify-otp-btn').prop('disabled', true).text('{{ translate("Verified") }}').removeClass('btn-outline-success').addClass('btn-success');
					} else {
						AIZ.plugins.notify('danger', response.message || 'Invalid OTP');
					}
				},
				error: function() {
					AIZ.plugins.notify('danger', 'Failed to verify OTP');
				},
				complete: function() {
					$('#verify-otp-btn').prop('disabled', false).text('{{ translate("Verify OTP") }}');
				}
			});
		}

		// Form submission validation
		$('#reg-form').on('submit', function(e) {
			var otp = $('#otp').val();
			var otpVerified = $('#verify-otp-btn').hasClass('btn-success');
			var regMethod = $('#registration_method').val() || 'email';
			var email = $('#signinSrEmail').val();
			var phone = $('#phone-code').val();

			if (regMethod === 'email') {
				if (!email) {
					AIZ.plugins.notify('warning', 'Please enter email address');
					$('#signinSrEmail').focus();
					e.preventDefault();
					return false;
				}
				var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				if (!emailReg.test(email)) {
					AIZ.plugins.notify('warning', 'Please enter a valid email address');
					$('#signinSrEmail').focus();
					e.preventDefault();
					return false;
				}
			} else {
				if (!phone) {
					AIZ.plugins.notify('warning', 'Please enter phone number');
					$('#phone-code').focus();
					e.preventDefault();
					return false;
				}
			}
			
			if (!otp) {
				AIZ.plugins.notify('warning', 'Please enter OTP');
				e.preventDefault();
				return false;
			}
			
			if (!otpVerified) {
				AIZ.plugins.notify('warning', 'Please verify OTP before submitting');
				e.preventDefault();
				return false;
			}
		});

		function togglePassword(targetId, sender) {
			var input = document.getElementById(targetId);
			var icon = sender.querySelector('i');
			if (input.type === "password") {
				input.type = "text";
				icon.classList.remove('la-eye');
				icon.classList.add('la-eye-slash');
			} else {
				input.type = "password";
				icon.classList.remove('la-eye-slash');
				icon.classList.add('la-eye');
			}
		}
	</script>
@endsection
