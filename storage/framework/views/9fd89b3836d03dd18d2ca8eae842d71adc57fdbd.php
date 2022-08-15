<?php $__env->startSection('content'); ?>

<?php if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin')): ?>

<div class="container">
	<div class="page-header">
		<h3>Генератор</h3>
	</div>
	<generator></generator>
</div>

<?php else: ?>
    
    <div class="head">
		<div class="face">
			<div class="eyes">
				<div class="eye first"></div>
				<div class="eye second"></div>
			</div>
			<div class="mouth"></div>
		</div>
	</div>

<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>