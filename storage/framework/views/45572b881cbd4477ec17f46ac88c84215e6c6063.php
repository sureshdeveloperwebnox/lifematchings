

<?php $__env->startSection('content'); ?>

<style>
    .carousel-box {
/* Make all carousel cards equal height */
.aiz-carousel .carousel-box {
    display: flex;
    align-items: stretch;
    height: 100%;
}

.aiz-carousel .carousel-box > div {
    display: flex;
    flex-direction: column;
    flex: 1;
}

/* Ensure card body fills full height */
.aiz-carousel .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    flex: 1;
}

/* Push price & button section to the bottom */
.aiz-carousel .card-body .mb-5.text-dark.text-center,
.aiz-carousel .card-body .text-center:last-child {
    margin-top: auto;
}

</style>


<div class="position-relative text-center text-white">
        <div class="bg-image" style="background: url('/public/assets/img/beautiful-woman-long-red-dress-walks-around-city-with-her-husband.jpg') center/cover no-repeat; height: 60vh;">
            <div class="d-flex h-100 w-100 align-items-center justify-content-center bg-dark bg-opacity-50">
                <div>
                    <h1 class="fw-bold">Select Your Package</h1>
                    <!-- <p class="lead">Discover our journey, values, and vision for the future.</p> -->
                </div>
            </div>
        </div>
    </div>

<!-- 
<section class="pt-6 pb-4 bg-white text-center">
    <div class="container">
        <h1 class="mb-0 fw-600 text-dark"><?php echo e(translate('Select Your Package')); ?></h1>
    </div>
</section> -->

<section class="py-5 bg-white">
    <div class="container">
        <div class="aiz-carousel" data-items="4" data-xl-items="3" data-md-items="2" data-sm-items="1" data-dots='true' data-infinite='true' data-autoplay='true'>
            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="carousel-box">
                    <div class="overflow-hidden shadow-none border-right">
                        <div class="card-body">
                            <div class="text-center mb-4 mt-3">
                                <img class="mw-100 mx-auto mb-4" src="<?php echo e(uploaded_asset($package->image)); ?>" height="130">
                                <h5 class="mb-3 h5 fw-600"><?php echo e($package->id == 1 ? translate('Free') : $package->name); ?></h5>
                            </div>


<ul class="list-group list-group-raw mb-5" style="font-size:13px;">

    
    <?php if($package->name == 'Elite'): ?>
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Relationship Manager
        </li>
        <li class="list-group-item py-2">
            <i class="las la-phone text-success mr-2"></i> Connect with your preferred matches, View <b>15 Verified Numbers</b>
        </li>
        <li class="list-group-item py-2">
            <i class="las la-microphone text-success mr-2"></i> Get Personal Marriage Recorded Voice Clip - 1
        </li>
        <li class="list-group-item py-2 mb-5">
            <i class="las la-database text-success mr-2"></i> Get Marriage Matching Recorded Voice Clip Across Others Matrimony Data - 3
        </li>
    <?php endif; ?>

    <?php if($package->name == 'Elite Super'): ?>
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Relationship Manager
        </li>
        <li class="list-group-item py-2">
            <i class="las la-phone text-success mr-2"></i> Connect with your preferred matches, View <b>25 Verified Numbers</b>
        </li>
        <li class="list-group-item py-2">
            <i class="las la-microphone text-success mr-2"></i> Get Personal Marriage Recorded Voice Clip - 1
        </li>
        <li class="list-group-item py-2 mb-5">
            <i class="las la-database text-success mr-2"></i> Get Marriage Matching Recorded Voice Clip Across Others Matrimony Data - 5
        </li>
    <?php endif; ?>

    <?php if($package->name == 'Elite Plus'): ?>
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Relationship Manager
        </li>
        <li class="list-group-item py-2">
            <i class="las la-phone text-success mr-2"></i> Connect with your preferred matches, View <b>35 Verified Numbers</b>
        </li>
        <li class="list-group-item py-2">
            <i class="las la-microphone text-success mr-2"></i> Get Personal Marriage Recorded Voice Clip - 1
        </li>
        <li class="list-group-item py-2 mb-5">
            <i class="las la-database text-success mr-2"></i> Get Marriage Matching Recorded Voice Clip Across Others Matrimony Data - 7
        </li>
    <?php endif; ?>

    <?php if($package->name == 'VIP'): ?>
        <li class="list-group-item py-2">
            <i class="las la-star text-success mr-2"></i> Personal Relationship Only
        </li>
        <li class="list-group-item py-2">
            <i class="las la-user-tie text-success mr-2"></i> Assistance from Astrologer Shanker Narrayan / Senior Relationship Manager for 6 Months
        </li>
        <li class="list-group-item py-2">
            <i class="las la-check text-success mr-2"></i> Senior Relationship Manager will share matching profiles periodically
        </li>
        <li class="list-group-item py-2">
            <i class="las la-envelope text-success mr-2"></i> All communications handled by Senior Relationship Manager
        </li>
        <li class="list-group-item ">
            <i class="las la-moon text-success mr-2"></i> Sending of Star/Horoscope matching profiles as and when available
        </li>
    <?php endif; ?>
</ul>






                            <div class="mb-5 text-dark text-center">
                                <?php if($package->id == 1): ?>
                                    <span class="display-4 fw-600 lh-1 mb-0"><?php echo e(translate('Free')); ?></span>
                                <?php else: ?>
                                    <span class="display-4 fw-600 lh-1 mb-0"><?php echo e(single_price($package->price)); ?></span>
                                <?php endif; ?>
                                <span class="text-secondary d-block"><?php echo e($package->validity); ?> <?php echo e(translate('Days')); ?></span>
                            </div>
                            <div class="text-center">
                                <?php if(Auth::check()): ?>
                                    <a href="<?php echo e(route('package_payment_methods', encrypt($package->id))); ?>" type="submit" class="btn btn-primary" ><?php echo e(translate('Purchase This Package')); ?></a>
                                <?php else: ?>
                                    <button type="submit" onclick="loginModal()" class="btn btn-primary" ><?php echo e(translate('Purchase This Package')); ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('modal'); ?>
    <?php echo $__env->make('modals.login_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('modals.package_update_alert_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">

	// Login alert
    function loginModal(){
        $('#LoginModal').modal();
    }

    // Package update alert
    function package_update_alert(){
      $('.package_update_alert_modal').modal('show');
    }

</script>
<?php $__env->stopSection(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PHP-Projects\lifematchings\httpdocs\resources\views/frontend/package/packages.blade.php ENDPATH**/ ?>