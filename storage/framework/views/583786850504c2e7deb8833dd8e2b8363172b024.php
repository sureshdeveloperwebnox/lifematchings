

<?php $__env->startSection('content'); ?>
<div class="py-4 py-lg-5">
	<div class="container">
		<div class="row">
			<div class="col-xxl-6 col-xl-6 col-md-8 mx-auto">
				<div class="card">
					<div class="card-body">

						<div class="mb-5 text-center">
							<h1 class="h3 text-primary mb-0"><?php echo e(translate('Create Your Account')); ?></h1>
							<p><?php echo e(translate('Fill out the form to get started')); ?>.</p>
						</div>
						<form class="form-default" id="reg-form" role="form" action="<?php echo e(route('register')); ?>" method="POST">
							<?php echo csrf_field(); ?>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="on_behalf"><?php echo e(translate('On Behalf')); ?></label>
										<?php $on_behalves = \App\Models\OnBehalf::all(); ?>
										<select class="form-control aiz-selectpicker <?php $__errorArgs = ['on_behalf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="on_behalf" required>
											<?php $__currentLoopData = $on_behalves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $on_behalf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option value="<?php echo e($on_behalf->id); ?>"><?php echo e($on_behalf->name); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>
										<?php $__errorArgs = ['on_behalf'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
							</div>
							<div class="row">
						        <div class="col-lg-6">
						            <div class="form-group mb-3">
										<label class="form-label" for="name"><?php echo e(translate('First Name')); ?></label>
										<input type="text" class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="first_name" id="first_name" placeholder="<?php echo e(translate('First Name')); ?>"  required>
										<?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
						            </div>
						        </div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name"><?php echo e(translate('Last Name')); ?></label>
										<input type="text" class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="last_name" id="last_name" placeholder="<?php echo e(translate('Last Name')); ?>"  required>
										<?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
    						</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="gender"><?php echo e(translate('Gender')); ?></label>
										<select class="form-control aiz-selectpicker <?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="gender" required>
											<option value="1"><?php echo e(translate('Male')); ?></option>
											<option value="2"><?php echo e(translate('Female')); ?></option>
										</select>
										<?php $__errorArgs = ['gender'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="name"><?php echo e(translate('Date Of Birth')); ?></label>
										<input type="text" class="form-control aiz-date-range <?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="date_of_birth" id="date_of_birth" placeholder="<?php echo e(translate('Date Of Birth')); ?>" data-single="true" data-show-dropdown="true" data-max-date="<?php echo e(get_max_date()); ?>" autocomplete="off" required>
										<?php $__errorArgs = ['date_of_birth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="timeOfBirth"><?php echo e(translate('Time Of Birth')); ?></label>
										<input type="time" class="form-control <?php $__errorArgs = ['timeOfBirth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
											name="timeOfBirth" id="timeOfBirth" 
											placeholder="<?php echo e(translate('HH:MM')); ?>" 
											required>
										<?php $__errorArgs = ['timeOfBirth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
								
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="birthPlace"><?php echo e(translate('Birth Place')); ?></label>
										<input type="text" class="form-control <?php $__errorArgs = ['birthPlace'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="birthPlace" id="birthPlace" placeholder="<?php echo e(translate('Birth Place')); ?>"  required>
										<?php $__errorArgs = ['birthPlace'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="phone"><?php echo e(translate('Phone Number')); ?></label>
										<div class="d-flex">
											<input type="tel" id="phone-code" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('phone')); ?>" placeholder="<?php echo e(translate('Enter phone number')); ?>" name="phone" autocomplete="off" required>
											<button type="button" class="btn btn-outline-primary flex-shrink-0" id="send-otp-btn" onclick="sendOTP()"><?php echo e(translate('Send OTP')); ?></button>
										</div>
										<?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
										<input type="hidden" name="country_code" value="">
									</div>
								</div>
							</div>
								

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="otp"><?php echo e(translate('OTP Verification')); ?></label>
										<div class="input-group d-flex">
											<input type="text" class="form-control <?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="otp" id="otp" placeholder="<?php echo e(translate('Enter OTP')); ?>" maxlength="6" required>
											<button type="button" class="btn btn-outline-success flex-shrink-0" id="verify-otp-btn" onclick="verifyOTP()"><?php echo e(translate('Verify OTP')); ?></button>
										</div>
										<?php $__errorArgs = ['otp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
							</div>
							

							<div class="row">
								<div class="col-lg-12">
								  <div class="form-group mb-3">
										<label class="form-label" for="email"><?php echo e(translate('Email address')); ?></label>
										<input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" id="signinSrEmail" placeholder="<?php echo e(translate('Email Address')); ?>" >
								        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								            <span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
								        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
								  </div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="password"><?php echo e(translate('Password')); ?></label>
										<div class="position-relative">
											<input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" id="password" placeholder="********" aria-label="********" required>
											<span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password', this)" style="cursor: pointer;">
												<i class="las la-eye"></i>
											</span>
										</div>
										<small><?php echo e(translate('Minimun 8 characters')); ?></small>
										<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
										<span class="invalid-feedback d-block" role="alert"><?php echo e($message); ?></span>
										<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group mb-3">
										<label class="form-label" for="password-confirm"><?php echo e(translate('Confirm password')); ?></label>
										<div class="position-relative">
											<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="********" required>
											<span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePassword('password_confirmation', this)" style="cursor: pointer;">
												<i class="las la-eye"></i>
											</span>
										</div>
										<small><?php echo e(translate('Minimun 8 characters')); ?></small>
									</div>
								</div>
							</div>

							<?php if(addon_activation('referral_system')): ?>
							<div class="row">
								<div class="col-lg-12">
									<div class="form-group mb-3">
										<label class="form-label" for="email"><?php echo e(translate('Referral Code')); ?></label>
										<input type="text" class="form-control<?php echo e($errors->has('referral_code') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('referral_code')); ?>" placeholder="<?php echo e(translate('Referral Code')); ?>" name="referral_code">
										<?php if($errors->has('referral_code')): ?>
											<span class="invalid-feedback" role="alert">
												<strong><?php echo e($errors->first('referral_code')); ?></strong>
											</span>
										<?php endif; ?>
									</div>
								</div>
							</div>
							<?php endif; ?>

							<?php if(get_setting('google_recaptcha_activation') == 1): ?>
							<div class="form-group">
								<div class="g-recaptcha" data-sitekey="<?php echo e(env('CAPTCHA_KEY')); ?>"></div>
								<?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
									<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
								<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
							</div>
							<?php endif; ?>

							<div class="mb-3">
								<label class="aiz-checkbox">
								<input type="checkbox" name="checkbox_example_1" required>
									<span class=opacity-60><?php echo e(translate('By signing up you agree to our')); ?>

										<a href="<?php echo e(env('APP_URL').'/terms-conditions'); ?>" target="_blank"><?php echo e(translate('terms and conditions')); ?>.</a>
									</span>
									<span class="aiz-square-check"></span>
								</label>
							</div>
							<?php $__errorArgs = ['checkbox_example_1'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
								<span class="invalid-feedback" role="alert"><?php echo e($message); ?></span>
							<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

							<div class="mb-5">
								<button type="submit" class="btn btn-block btn-primary"><?php echo e(translate('Create Account')); ?></button>
							</div>
							

							<div class="text-center">
								<p class="text-muted mb-0"><?php echo e(translate("Already have an account?")); ?></p>
								<a href="<?php echo e(route('login')); ?>"><?php echo e(translate('Login to your account')); ?></a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?>



<?php $__env->startSection('script'); ?>
	<?php if(get_setting('google_recaptcha_activation') == 1): ?>
		<?php echo $__env->make('partials.recaptcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	<?php endif; ?>
	
	<script type="text/javascript">
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
			utilsScript: "<?php echo e(static_asset('assets/js/intlTelutils.js')); ?>?1590403638580",
			onlyCountries: <?php echo json_encode(\App\Models\Country::where('status', 1)->pluck('code')->toArray()) ?>,
			customPlaceholder: function(selectedCountryPlaceholder, selectedCountryData) {
				if (selectedCountryData.iso2 == 'bd') {
					return "01xxxxxxxxx";
				}
				return selectedCountryPlaceholder;
			}
		});

		var country = iti.getSelectedCountryData();
		$('input[name=country_code]').val(country.dialCode);

		input.addEventListener("countrychange", function(e) {
			var country = iti.getSelectedCountryData();
			$('input[name=country_code]').val(country.dialCode);
		});

		function sendOTP() {
			var phone = $('#phone-code').val();
			var countryCode = $('input[name=country_code]').val();
			
			if (!phone) {
				AIZ.plugins.notify('warning', '<?php echo e(translate("Please enter phone number")); ?>');
				return;
			}
			
			$('#send-otp-btn').prop('disabled', true).text('<?php echo e(translate("Sending...")); ?>');
			
			$.ajax({
				url: '<?php echo e(route("send.otp")); ?>',
				type: 'POST',
				data: {
					phone: phone,
					country_code: countryCode,
					_token: '<?php echo e(csrf_token()); ?>'
				},
				success: function(response) {
					if (response.success) {
						AIZ.plugins.notify('success', 'OTP sent successfully!');
						$('#otp').focus();
						// Start 30 second countdown
						startOTPCountdown();
					} else {
						AIZ.plugins.notify('danger', response.message || 'Failed to send OTP');
						$('#send-otp-btn').prop('disabled', false).text('<?php echo e(translate("Send OTP")); ?>');
					}
				},
				error: function() {
					AIZ.plugins.notify('danger', 'Failed to send OTP');
					$('#send-otp-btn').prop('disabled', false).text('<?php echo e(translate("Send OTP")); ?>');
				}
			});
		}

		function startOTPCountdown() {
			var countdown = 30;
			var $btn = $('#send-otp-btn');
			
			$btn.prop('disabled', true);
			
			var timer = setInterval(function() {
				$btn.text('<?php echo e(translate("Resend OTP")); ?> (' + countdown + 's)');
				countdown--;
				
				if (countdown < 0) {
					clearInterval(timer);
					$btn.prop('disabled', false).text('<?php echo e(translate("Send OTP")); ?>');
				}
			}, 1000);
		}

		function verifyOTP() {
			var otp = $('#otp').val();
			
			if (!otp) {
				AIZ.plugins.notify('warning', '<?php echo e(translate("Please enter OTP")); ?>');
				return;
			}
			
			$('#verify-otp-btn').prop('disabled', true).text('<?php echo e(translate("Verifying...")); ?>');
			
			$.ajax({
				url: '<?php echo e(route("verify.otp")); ?>',
				type: 'POST',
				data: {
					otp: otp,
					_token: '<?php echo e(csrf_token()); ?>'
				},
				success: function(response) {
					if (response.success) {
						AIZ.plugins.notify('success', 'OTP verified successfully!');
						$('#otp').prop('readonly', true);
						$('#verify-otp-btn').prop('disabled', true).text('<?php echo e(translate("Verified")); ?>').removeClass('btn-outline-success').addClass('btn-success');
					} else {
						AIZ.plugins.notify('danger', response.message || 'Invalid OTP');
					}
				},
				error: function() {
					AIZ.plugins.notify('danger', 'Failed to verify OTP');
				},
				complete: function() {
					$('#verify-otp-btn').prop('disabled', false).text('<?php echo e(translate("Verify OTP")); ?>');
				}
			});
		}

		// Form submission validation
		$('#reg-form').on('submit', function(e) {
			var otp = $('#otp').val();
			var otpVerified = $('#verify-otp-btn').hasClass('btn-success');
			
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PHP-Projects\lifematchings\httpdocs\resources\views/frontend/user_registration.blade.php ENDPATH**/ ?>