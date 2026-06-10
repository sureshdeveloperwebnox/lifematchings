

<?php $__env->startSection('content'); ?>
<div class="py-4 py-lg-5">
    <div class="container">
        <div class="row">
            <div class="col-xxl-4 col-xl-5 col-md-7 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-5 text-center">
                            <h1 class="h3 text-primary mb-0"><?php echo e(translate('Login to your account')); ?></h1>
                        </div>

                        <form class="" method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label class="form-label" for="email">
                                    <?php echo e(translate('Email/Phone')); ?>

                                </label>
                                <input type="text" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(translate('Email Or Phone')); ?>" name="email" id="email">
                                <?php if($errors->has('email')): ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                <?php endif; ?>
                                <span class="opacity-60"><?php echo e(translate('Enter your email or phone number')); ?></span>
                            </div>

                            <div class="form-group position-relative mb-3">
                                <label class="form-label" for="password"><?php echo e(translate('Password')); ?></label>
                                <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" id="password" placeholder="********" required>
                                <span class="position-absolute top-50 end-0 translate-middle-y pe-3" onclick="togglePasswordVisibility()" style="cursor: pointer;">
                                    <i class="las la-eye" id="togglePasswordIcon"></i>
                                </span>
                                <?php $__errorArgs = ['password'];
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



                            <div class="mb-3 text-right">
                                <a class="link-muted text-capitalize font-weight-normal" href="<?php echo e(route('password.request')); ?>"><?php echo e(translate('Forgot Password?')); ?></a>
                            </div>

                            <div class="mb-5">
                                <button type="submit" class="btn btn-block btn-primary"><?php echo e(translate('Login to your Account')); ?></button>
                            </div>
                        </form>
                        <?php if(env("DEMO_MODE") == "On"): ?>
                            <div class="mb-5">
                                <table class="table table-bordered table-responsive">
                                    <tbody>
                                        <tr>
                                            <td>user2@example.com</td>
                                            <td>12345678</td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary btn-xs" onclick="autoFill1()"><?php echo e(translate('Copy credentials')); ?></button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>user17@example.com</td>
                                            <td>12345678</td>
                                            <td class="text-center">
                                                <button class="btn btn-outline-primary btn-xs" onclick="autoFill2()"><?php echo e(translate('Copy credentials')); ?></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>

                        <?php if(get_setting('google_login_activation') == 1 || get_setting('facebook_login_activation') == 1 || get_setting('twitter_login_activation') == 1 || get_setting('apple_login_activation') == 1): ?>
                            <div class="separator mb-3">
                                <span class="bg-white px-3 opacity-60"><?php echo e(translate('Or Login With')); ?></span>
                            </div>
                            <ul class="list-inline social colored text-center mb-5">
                                <?php if(get_setting('facebook_login_activation') == 1): ?>
                                    <li class="list-inline-item">
                                        <a href="<?php echo e(route('social.login', ['provider' => 'facebook'])); ?>" class="facebook">
                                            <i class="lab la-facebook-f"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('google_login_activation') == 1): ?>
                                    <li class="list-inline-item">
                                        <a href="<?php echo e(route('social.login', ['provider' => 'google'])); ?>" class="google">
                                            <i class="lab la-google"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('twitter_login_activation') == 1): ?>
                                    <li class="list-inline-item">
                                        <a href="<?php echo e(route('social.login', ['provider' => 'twitter'])); ?>" class="twitter">
                                            <i class="lab la-twitter"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if(get_setting('apple_login_activation') == 1): ?>
                                    <li class="list-inline-item">
                                        <a href="<?php echo e(route('social.login', ['provider' => 'apple'])); ?>" class="apple">
                                            <i class="lab la-apple"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        <?php endif; ?>
                        <div class="text-center">
                            <p class="text-muted mb-0"><?php echo e(translate("Don't have an account?")); ?></p>
                            <a href="<?php echo e(route('register')); ?>"><?php echo e(translate('Create an account')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('togglePasswordIcon');
        const isPasswordVisible = passwordInput.type === 'text';

        passwordInput.type = isPasswordVisible ? 'password' : 'text';
        toggleIcon.classList.toggle('la-eye');
        toggleIcon.classList.toggle('la-eye-slash');
    }


</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PHP-Projects\lifematchings\httpdocs\resources\views/frontend/user_login.blade.php ENDPATH**/ ?>