<?php $__env->startSection('content'); ?>

    <div id="app">

        <tasks :group-id="'<?php echo e($group_id); ?>'"></tasks>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>