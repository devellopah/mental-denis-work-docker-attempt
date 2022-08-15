<?php $__env->startSection('content'); ?>
    <?php if(!empty($tasks)): ?>
        <div class="container tasks__page">
            <div class="row">
                <div class="page-header">
                    <h2>Список заданий</h2>
                </div>
                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="row tasks__wrap">
                    <?php $__currentLoopData = $tasks->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 tasks__container">
                            <div class="well clearfix">
                                <a href="<?php echo e(url("/task/$task->id")); ?>">
                                    <h4 class="tasks__name tasks__header"><?php echo e($task->name); ?></h4>
                                </a>
                                <?php if($task->avatar !== null): ?>
                                    <div class="tasks__image">
                                        <img src="<?php echo e($task->avatar->src); ?>" alt="">
                                    </div>
                                <?php endif; ?>
                                <br>
                                <div class="row tasks__description">
                                    <div class="col-xs-9">
                                        <p class="text-muted">
                                            <?php echo e($task->description_short); ?>

                                        </p>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <br>
                                <div class="row text-small flex-center-between tasks__times__wrap">
                                    <div class="row">
                                           <span class="tasks__times">
                                            <i class="material-icons text-danger">&#xE190;</i>&nbsp;
                                               <?php echo e($task->starting_at); ?>

                                               -
                                               <?php echo e($task->expires_at); ?>

                                            </span>
                                    </div>
                                    <?php if($task->status): ?>
                                        <span class="tasks__times">
                                                  <i class="text-<?php echo e(config("task.classes.$task->status")); ?> material-icons">&#xE88E;</i>
                                                  &nbsp;
                                            <?php echo e(config("task.$task->status")); ?>

                                                </span>
                                    <?php endif; ?>
                                    <div class="row text-right">
                                        <a href="<?php echo e(url("task/$task->id")); ?>"
                                           class="pull-right btn btn-raised btn-danger btn-lg tasks__button mental-btn-1">
                                            Продолжить
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <div class="text-center">
                    <?php echo e($tasks->links()); ?>

                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>