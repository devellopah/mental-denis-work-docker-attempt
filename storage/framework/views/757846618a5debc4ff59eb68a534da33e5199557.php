<?php $__env->startSection('content'); ?>

<?php if($inGroup): ?>

	<div class="container student-dashboard">
        <div class="row student-dashboard__block">

            <?php if($student->group->message): ?>

            <div class="col-xs-8">
                <h2>Групповое сообщение</h2>

                <div class="student-message">
                    <?php echo e($student->group->message); ?>

                </div>  
               
            </div>

            <div class="col-xs-4">
                <div class="userpic-block">
                    <div class="userpic-block__image">
                        <img src="/images/avatars/<?php echo e($student->group->user->avatar); ?>" alt="avatar" class="img-responsive">
                    </div>
                    <div class="userpic-block__name"><?php echo e($student->group->user->name); ?></div>
                </div>
            </div>

            <?php endif; ?>

        </div> 

        <?php if($student->message): ?>

        <div class="row student-dashboard__block">

            <div class="col-xs-8">
                <h2>Личное сообщение</h2>

                <div class="student-message">
                    <?php echo e($student->message); ?>

                </div> 
               
            </div>

            <div class="col-xs-4">
                <div class="userpic-block">
                    <div class="userpic-block__image">
                        <img src="/images/avatars/<?php echo e($student->group->user->avatar); ?>" alt="avatar" class="img-responsive">
                    </div>
                    <div class="userpic-block__name"><?php echo e($student->group->user->name); ?></div>
                </div>
            </div>

        </div> 

        <?php endif; ?>

    </div>

<?php endif; ?>;
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>