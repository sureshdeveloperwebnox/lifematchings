


<div class="<?php if(get_setting('header_stikcy') == 'on'): ?> position-fixed <?php else: ?> position-absolute <?php endif; ?> w-100 top-0 z-1020">
    <div class="top-navbar bg-white border-bottom z-1035 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col">

                <div class="logo ">
                        <a href="<?php echo e(route('home')); ?>" class="d-inline-block ">
                            <?php if(get_setting('header_logo') != null): ?>
                            <img src="<?php echo e(uploaded_asset(get_setting('header_logo'))); ?>" alt="<?php echo e(env('APP_NAME')); ?>"
                                class="mw-100 h-30px h-md-90px" height="20">
                            <?php else: ?>
                            <img src="<?php echo e(static_asset('assets/img/logo.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>"
                                class="mw-100 h-30px h-md-60px" height="20">
                            <?php endif; ?>
                        </a>
                    </div>
                    <ul class="list-inline d-flex justify-content-between justify-content-lg-start mb-0">
                        <li class="list-inline-item">
                          <a href="<?php echo e(get_setting('header_left_quick_link1')); ?>" class="text-reset opacity-60">
                            <span><?php echo e(get_setting('header_left_quick_link1_text')); ?></span>
                          </a>
                        </li>
                    </ul>
                </div>

<!--  -------------------------------------------------- -->
                <style>
                    .header-icon{
                        font-size: 35px;
                        color: #FD00D1;
                    }
                    .button{
                        background-size: 100% 100%;
                        background-position: 0px 0px;
                        /* background-image: linear-gradient(90deg, #FD00D1 0%, #71C4FFFF 100%); */
                        background-color: #BD099D;
                    }
                    /* .button:hover{
                        background-color: ;
                    } */
                </style>
<!----------------------------------------------------- -->
                <div class="col-lg-7 col">

                    <ul class="list-inline mb-0 d-flex align-items-center justify-content-end text-nowrap">
                        <li class="list-inline-item d-flex align-items-center mr-4">
                            <i class="las la-envelope header-icon"></i>
                            <span class="opacity-80 pl-2">info@lifematchings.com</span>
                        </li>
                        <li class="list-inline-item d-flex align-items-center mr-4">
                            <i class="las la-phone header-icon"></i>
                            <span class="opacity-80 pl-2">99411 61613</span>
                        </li>
                        <?php if(Auth::check()): ?>
                        <li class="list-inline-item dropdown d-flex align-items-center ml-3">
                            <?php
                            $notifications = \App\Models\Notification::latest()->where('notifiable_id',Auth()->user()->id)->take(10)->get();
                            $unseen_notification = \App\Models\Notification::where('notifiable_id',Auth()->user()->id)->where('read_at',null)->count();
                            ?>
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset no-arrow p-0"
                                data-toggle="dropdown" data-display="static">
                                <i class="las la-bell fs-16 opacity-60"></i>
                                <?php if($unseen_notification > 0): ?>
                                <span class="badge badge-dot badge-sm badge-status no-border badge-primary"></span>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">
                                <div class="p-3 bg-light border-bottom">
                                    <h6 class="mb-0"><?php echo e(translate('Notifications')); ?></h6>
                                </div>
                                <ul class="list-group list-group-raw c-scrollbar-light"
                                    style="overflow-y:auto;max-height:300px;">
                                    <?php echo $__env->make('frontend.inc.notification', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                </ul>
                                <div class="border-top">
                                    <a href="<?php echo e(route('frontend.notifications')); ?>"
                                        class="btn text-reset btn-block"><?php echo e(translate('View All Notifications')); ?></a>
                                </div>
                            </div>
                        </li>
                        <?php
                        $unseen_chat_threads = chat_threads();
                        $unseen_chat_thread_count = count($unseen_chat_threads);
                        ?>
                        <li class="list-inline-item dropdown d-flex align-items-center ml-3">
                            <a href="javascript:void(0)" class="dropdown-toggle text-reset no-arrow p-0"
                                data-toggle="dropdown" data-display="static">
                                <i class="las la-envelope fs-16 opacity-60"></i>
                                <?php if($unseen_chat_thread_count > 0): ?>
                                <span class="badge badge-dot badge-sm badge-status no-border badge-primary"></span>
                                <?php endif; ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg py-0">
                                <div class="p-3 bg-light border-bottom">
                                    <h6 class="mb-0"><?php echo e(translate('Messages')); ?></h6>
                                </div>

                                <div class="c-scrollbar-light" style="overflow-y:auto;max-height:300px;">
                                    <?php $__empty_1 = true; $__currentLoopData = $unseen_chat_threads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $chat_thread_id): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                    $chat = \App\Models\Chat::where('chat_thread_id', $chat_thread_id)->latest()->first();
                                    $current_user = Auth::user()->id;
                                    ?>

                                    <?php if($chat != null): ?>
                                    <a href="<?php echo e(route('all.messages')); ?>"
                                        class="chat-user-item p-3 d-block text-inherit hov-bg-soft-primary">
                                        <div class="media">
                                            <span class="avatar avatar-sm mr-3 flex-shrink-0">
                                                <?php if($current_user == $chat->chatThread->sender->id): ?>
                                                <?php $user_to_show = 'receiver'; ?>
                                                <?php else: ?>
                                                <?php $user_to_show = 'sender'; ?>
                                                <?php endif; ?>
                                                <?php if($chat->chatThread->$user_to_show->photo != null): ?>
                                                <img src="<?php echo e(uploaded_asset($chat->chatThread->$user_to_show->photo)); ?>">
                                                <?php else: ?>
                                                <img src="<?php echo e(static_asset('assets/img/avatar-place.png')); ?>">
                                                <?php endif; ?>
                                                <?php if(Cache::has('user-is-online-' . $chat->chatThread->$user_to_show->id)): ?>
                                                <span
                                                    class="badge badge-dot badge-circle badge-success badge-status badge-md"></span>
                                                <?php else: ?>
                                                <span
                                                    class="badge badge-dot badge-circle badge-secondary badge-status badge-md"></span>
                                                <?php endif; ?>
                                            </span>
                                            <div class="media-body minw-0">
                                                <h6 class="mt-0 mb-1 fs-14 text-truncate">
                                                    <?php echo e($chat->chatThread->$user_to_show->first_name.' '.$chat->chatThread->$user_to_show->last_name); ?>

                                                </h6>
                                                <?php if($chat->message != null): ?>
                                                <div class="fs-12 text-truncate opacity-60"><?php echo e($chat->message); ?></div>
                                                <?php else: ?>
                                                <div class="fs-12 text-truncate opacity-60"><?php echo e(translate('Attachments')); ?>

                                                </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-2 text-right">
                                                <div class="opacity-60 fs-10 mb-1">
                                                    <?php echo e(Carbon\Carbon::parse($chat->created_at)->diffForHumans()); ?></div>
                                            </div>
                                        </div>
                                    </a>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center py-4">
                                        <i class="las la-frown la-4x mb-2 opacity-40"></i>
                                        <h4 class="h6"><?php echo e(translate('No New Messages')); ?></h4>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="border-top">
                                    <a href="<?php echo e(route('all.messages')); ?>"
                                        class="btn text-reset btn-block"><?php echo e(translate('View All Messages')); ?></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-inline-item d-flex align-items-center mx-4">
                            <a href="<?php echo e(route('dashboard')); ?>" class="d-flex align-items-center text-reset">
                                <img src="<?php echo e(uploaded_asset(Auth::user()->photo)); ?>"
                                    class="size-30px rounded-circle img-fit mr-2"
                                    onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/avatar-place.png')); ?>';">
                                <span class="opacity-60 mr-1">
                                    <?php echo e(translate('Hi')); ?>,
                                </span>
                                <span class="text-primary-grad fw-700">
                                    <?php echo e(Auth::user()->first_name); ?>

                                </span>
                            </a>
                        </li>
                        <li class="list-inline-item d-flex align-items-center">
                            <a href="<?php echo e(route('profile_settings')); ?>"
                                class="btn btn-sm button text-white fw-600 py-1 border"><?php echo e(translate('My Profile')); ?></a>
                        </li>
                        <?php else: ?>
                        <li class="list-inline-item ml-4">
                            <a class="btn btn-sm button text-white fw-600 py-1 border" href="<?php echo e(route('login')); ?>"><?php echo e(translate('Log In')); ?></a>
                        </li>
                        <li class="list-inline-item ml-3">
                            <a class="btn btn-sm button text-white fw-600 py-1 border"
                                href="<?php echo e(route('register')); ?>"><?php echo e(translate('Registration')); ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<!-- ------------------------------------- -->
<style>
    .bg-color{
        background-color: #BD099D;
    }
</style>
<!-- ------------------------------------------->

    <!-- <header
        class="aiz-header shadow-md bg-white border-gray-300">
        <div class="aiz-navbar position-relative bg-color">
            <div class="container">
            <div class="d-lg-flex justify-content-center text-center text-lg-left w-100">
                <ul class="my-3 pl-10 d-lg-flex align-items-center justify-content-center w-100 ">
                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center <?php echo e(areActiveRoutes(['home'],)); ?>">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('home')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('Home')); ?></span>
                        </a>
                    </li>
                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('about.us')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('About Us')); ?></span>
                        </a>
                    </li>

                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center <?php echo e(areActiveRoutes(['member.listing'],'bg-primary-grad')); ?>">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('member.listing')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('Service')); ?></span>
                        </a>
                    </li>
                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center <?php echo e(areActiveRoutes(['packages'],'bg-primary-grad')); ?>">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('packages')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('Packages')); ?></span>
                        </a>
                    </li>
                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center <?php echo e(areActiveRoutes(['happy_stories'],'bg-primary-grad')); ?>">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('happy_stories')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('Membership Plan')); ?></span>
                        </a>
                    </li>
                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center <?php echo e(areActiveRoutes(['contact_us'],'bg-primary-grad')); ?>">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('contact_us')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('Contact')); ?></span>
                        </a>
                    </li>
                    <li class="d-inline-block d-lg-flex pb-1 flex-grow-1 text-center <?php echo e(areActiveRoutes(['contact_us'],'bg-primary-grad')); ?>">
                        <a class="nav-link text-uppercase fw-700 fs-15 d-flex align-items-center justify-content-center py-2"
                            href="<?php echo e(route('contact_us')); ?>">
                            <span class="text-white mb-n1"><?php echo e(translate('Success Stories')); ?></span>
                        </a>
                    </li>
                </ul>
            </div>

            </div>
        </div> -->

        

    <style>
        /* Custom White Toggle Icon */
        .navbar-toggler {
            border: none;
        }
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba(255, 255, 255, 1)' stroke-width='3' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }
    </style> 


<style>
  .custom-login-btn {
    background-color: #ffff; /* or #d000a4 to match the screenshot */
    color: #c400a2;
    border-radius: 6px;
    font-size: 14px;
    padding: 6px 12px;
    line-height: 1.2;
    display: inline-block;
  }

  /*.custom-login-btn:hover {*/
    background-color: #ffff; /* darker shade on hover */
  /*  text-decoration: none;*/
  /*}*/
</style>

<header class="aiz-header shadow-md bg-white border-gray-300">
  <nav class="navbar navbar-expand-lg aiz-navbar position-relative bg-color" style="padding: 15px;">
    <div class="container">
      
      <!-- Mobile View Header Row -->
      <div class="d-flex d-lg-none justify-content-between align-items-center w-100">
        
        <!-- Logo -->
        <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
          <img src="/public/assets/img/Logo-04.png" alt="Logo" width="120" height="50">
        </a>

        <!-- Right Side (Buttons + Menu) -->
        <div class="d-flex align-items-center gap-2">
          
          <?php if(auth()->guard()->guest()): ?>
            <!-- Show when NOT logged in -->
            <a class="btn btn-sm custom-login-btn fw-600 px-2 py-1" href="<?php echo e(route('login')); ?>">
              <?php echo e(translate('Log In')); ?>

            </a>
          <?php endif; ?>

          <?php if(auth()->guard()->check()): ?>
            <!-- Show when logged in -->
            <a class="btn btn-sm button text-white fw-600 px-2 py-1" href="<?php echo e(route('dashboard')); ?>">
              <?php echo e(translate('Dashboard')); ?>

            </a>
            <div class="col">
                    <a href="javascript:void(0)" class="text-reset d-block flex-grow-1 text-center py-2 mobile-side-nav-thumb" data-toggle="class-toggle" data-target=".aiz-mobile-side-nav">
                        <span class="d-block mx-auto mb-1 opacity-100">
                            <img src="<?php echo e(uploaded_asset(Auth::user()->photo)); ?>" class="rounded-circle size-30px" onerror="this.onerror=null;this.src='<?php echo e(static_asset('assets/img/avatar-place.png')); ?>';">
                        </span>
                    </a>
                </div>
          <?php endif; ?>

          <!-- Hamburger Menu -->
          <button class="navbar-toggler ms-2" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>

      <!-- Desktop View Header -->
      <div class="collapse navbar-collapse justify-content-center text-center text-lg-left w-100 mt-3 mt-lg-0" id="navbarNav">
        <ul class="navbar-nav w-100 d-lg-flex align-items-center justify-content-end gap-4">
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('home')); ?>"><?php echo e(translate('Home')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('about.us')); ?>"><?php echo e(translate('About Us')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('service')); ?>"><?php echo e(translate('Services')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('member.listing')); ?>"><?php echo e(translate('Active Members')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('packages')); ?>"><?php echo e(translate('Packages')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('happy_stories')); ?>"><?php echo e(translate('Success Stories')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('contact_us')); ?>"><?php echo e(translate('Contact us')); ?></a></li>
          <li class="nav-item"><a class="nav-link text-white sm-display-block d-lg-none text-uppercase fw-700 fs-15 py-2" href="<?php echo e(route('logout')); ?>"><?php echo e(translate('Logout')); ?></a></li>
          <?php if(auth()->guard()->check()): ?>
            <!-- Desktop view Dashboard/Logout -->
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
</header>

<script>
$(document).ready(function() {
    // Fix mobile navigation toggle
    $('.navbar-toggler').on('click', function() {
        var target = $(this).data('target');
        var isExpanded = $(this).attr('aria-expanded') === 'true';
        
        if (isExpanded) {
            // Close the menu
            $(target).collapse('hide');
            $(this).attr('aria-expanded', 'false');
        } else {
            // Open the menu
            $(target).collapse('show');
            $(this).attr('aria-expanded', 'true');
        }
    });
    
    // Close menu when clicking on a nav link (mobile)
    $('.navbar-nav .nav-link').on('click', function() {
        if ($(window).width() < 992) { // Only on mobile
            $('#navbarNav').collapse('hide');
            $('.navbar-toggler').attr('aria-expanded', 'false');
        }
    });
    
    // Close menu when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.navbar').length) {
            $('#navbarNav').collapse('hide');
            $('.navbar-toggler').attr('aria-expanded', 'false');
        }
    });
});
</script>


        <?php if(Auth::check() && auth()->user()->user_type == 'member'): ?>
            <div class="border-top d-none d-lg-block" style="background-color: #ffff;">
                <div class="container">
                    <ul class="list-inline d-flex align-items-center mb-0 text-nowrap">
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('dashboard')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['dashboard'],'text-primary-grad opacity-100')); ?>">
                                <i class="las la-tachometer-alt mr-1"></i>
                                <span><?php echo e(translate('Dashboard')); ?></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('profile_settings')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['profile_settings'],'text-primary-grad opacity-100')); ?>">
                                <i class="las la-user mr-1"></i>
                                <span><?php echo e(translate('My Profile')); ?></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('my_interests.index')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['express-interest.index'],'text-primary-grad opacity-100')); ?>">
                                <i class="la la-heart-o mr-1"></i>
                                <span><?php echo e(translate('My Interest')); ?></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('my_shortlists')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['my_shortlists'],'text-primary-grad opacity-100')); ?>">
                                <i class="las la-list mr-1"></i>
                                <span><?php echo e(translate('Shortlist')); ?></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('all.messages')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['all.messages'],'text-primary-grad opacity-100')); ?>">
                                <i class="las la-envelope mr-1"></i>
                                <span><?php echo e(translate('Messaging')); ?></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('my_ignored_list')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['my_ignored_list'],'text-primary-grad opacity-100')); ?>">
                                <i class="las la-ban mr-1"></i>
                                <span><?php echo e(translate('Ignored User List')); ?></span>
                            </a>
                        </li>
                        <?php if(Auth::user()->member->auto_profile_match == 1): ?>
                            <li class="list-inline-item">
                                <a href="<?php echo e(route('my_matched_profiles')); ?>"
                                    class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['my_matched_profiles'],'text-primary-grad opacity-100')); ?>">
                                    <i class="las la-user-friends"></i>
                                    <span><?php echo e(translate('Matched profile')); ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('profile-viewers.index')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600 <?php echo e(areActiveRoutes(['profile-viewers.index'],'text-primary-grad opacity-100')); ?>">
                                <i class="las la-eye mr-1"></i>
                                <span><?php echo e(translate('Profile Viewers')); ?></span>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="<?php echo e(route('logout')); ?>"
                                class="text-reset d-inline-block px-4 py-3 fw-600"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="las la-sign-out-alt mr-1"></i>
                                <span><?php echo e(translate('Logout')); ?></span>
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                <?php echo csrf_field(); ?>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>
    </header>
</div>
<?php /**PATH D:\PHP-Projects\lifematchings\httpdocs\resources\views/frontend/inc/header.blade.php ENDPATH**/ ?>