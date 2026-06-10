
<?php $__env->startSection('content'); ?>
<section class="py-5 bg-white">
	<div class="container">
		<div class="d-flex align-items-start">
			<?php echo $__env->make('frontend.member.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
			<div class="aiz-user-panel overflow-hidden">
				<?php echo $__env->yieldContent('panel_content'); ?>
			</div>
		</div>
	</div>
</section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('frontend.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\PHP-Projects\lifematchings\httpdocs\resources\views/frontend/layouts/member_panel.blade.php ENDPATH**/ ?>