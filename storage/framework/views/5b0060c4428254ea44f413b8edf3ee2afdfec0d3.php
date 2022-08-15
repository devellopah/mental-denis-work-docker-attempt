<?php $__env->startSection('content'); ?>

    <main class="pdg" id="app">
        <div class="container">
            <div class="acc block-bg">
                <div class="user-photo">
                    <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                        <img src="/images/avatars/<?php echo e($user->avatar); ?>" alt="">
                    </a>
                </div>
                <div class="acc__btns btns">
                    <a href="<?php echo e(url('/users')); ?>" class="btn-blue icon-arrow-back"><span></span></a>
                </div>
                <div class="acc__top">
                    <div class="acc__top-left">
                        <div class="acc__points">
                            <span>Баллов</span>
                            81 443.7
                        </div>
                    </div>
                </div>
                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php echo Form::open(array('url' => route('teacher.update_student', ['student_id' => $user->id]))); ?>

                <?php echo e(csrf_field()); ?>

                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Имя</span>
                            <input id="name" type="text" class="field" name="name" value="<?php echo e($user->name); ?>" readonly>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">E-mail</span>
                            <input id="name" type="text" class="field" name="name" value="<?php echo e($user->email); ?>" readonly>
                        </label>
                    </div>
                    <div class="col l12 s12">
                        <?php if($showStats): ?>
                            <?php $__env->startComponent('components.student_stats', ['student' => $student, 'container' => true]); ?>
                            <?php echo $__env->renderComponent(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </main>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>