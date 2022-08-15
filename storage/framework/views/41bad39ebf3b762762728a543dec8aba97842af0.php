<div class="clearfix">
    <?php if(!empty($messages)): ?>
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="label label-<?php echo e($message['code']); ?>"><?php echo e($message['text']); ?></div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <br>
        <br>
    <?php endif; ?>
</div>