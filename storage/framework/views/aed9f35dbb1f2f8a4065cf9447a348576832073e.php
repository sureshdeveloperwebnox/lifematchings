<?php if(auth()->user()->user_type == 'member'): ?>
    <?php if($notifications->count() > 0): ?>
        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $check = 'done';
                $notify_data = json_decode($notification->data);
                $user_data = \App\Models\User::where('id', $notify_data->notify_by)->first();
            ?>
            <?php if($notify_data->type == 'express_interest'): ?>
                <?php
                    $interest_data = App\Models\ExpressInterest::where('id', $notify_data->info_id)->first();
                    if (empty($interest_data)) {
                        $check = 'not_done';
                    }
                ?>
            <?php endif; ?>
            <?php if($check == 'done' && !empty($user_data)): ?>
                <li class="list-group-item d-flex justify-content-between align-items-start hov-bg-soft-primary">
                    <a href="<?php echo e(route('notification_view', $notification->id)); ?>" class="media text-inherit">
                        <span class="avatar avatar-sm mr-3">
                            <?php
                                $avatar_image = $user_data->member->gender == 1 ? 'assets/img/avatar-place.png' : 'assets/img/female-avatar-place.png';
                                $profile_picture_show = show_profile_picture($user_data);
                            ?>
                            <img <?php if($profile_picture_show): ?> src="<?php echo e(uploaded_asset($user_data->photo)); ?>"
                            <?php else: ?>
                            src="<?php echo e(static_asset($avatar_image)); ?>" <?php endif; ?>
                                onerror="this.onerror=null;this.src='<?php echo e(static_asset($avatar_image)); ?>';">
                        </span>
                        <div class="media-body">
                            <p class="mb-1"><?php echo e($user_data->first_name . ' ' . $user_data->last_name); ?></p>
                            <small class="text-muted">
                                <?php echo e($notify_data->message); ?>

                            </small>
                        </div>
                    </a>
                    <?php if($notification->read_at == null): ?>
                        <button class="btn p-0">
                            <span class="badge badge-md  badge-dot badge-circle badge-primary"></span>
                        </button>
                    <?php endif; ?>
                </li>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <li class="list-group-item">
            <div class="text-center">
                <i class="las la-frown la-4x mb-4 opacity-40"></i>
                <h4 class="h5"><?php echo e(translate('No Notifications')); ?></h4>
            </div>
        </li>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH D:\PHP-Projects\lifematchings\httpdocs\resources\views/frontend/inc/notification.blade.php ENDPATH**/ ?>