<?php $__env->startSection('content'); ?>

    <main class="pdg" id="app">
        <div class="container">
            <div class="acc block-bg">
                <div class="user-photo">
                    <a href="#" data-featherlight="/images/avatars/<?php echo e($student->user->avatar); ?>">
                        <img src="/images/avatars/<?php echo e($student->user->avatar); ?>" alt="">
                    </a>
                </div>
                <div class="acc__btns btns">
                    <form action="<?php echo e(route('teacher.remove_student', ['student_id' => $student->id])); ?>" method="post">
                        <?php echo e(csrf_field()); ?>

                        <a href="<?php echo e(url('/users')); ?>" class="btn-blue icon-arrow-back"><span></span></a>
                        <a href="<?php echo e(url('/teacher/groups')); ?>" class="btn-blue"><span></span><b>Мои ученики</b></a>
                        <button id="studentRemove" type="submit" class="btn-blue icon-del" title="Удалить из группы"><span></span></button>
                    </form>
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
                <?php echo Form::open(array('url' => route('teacher.update_student', ['student_id' => $student->id]))); ?>

                <?php echo e(csrf_field()); ?>

                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Имя</span>
                            <input id="name" type="text" class="field" name="name" value="<?php echo e($student->user->name); ?>" readonly>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">E-mail</span>
                            <input id="name" type="text" class="field" name="name" value="<?php echo e($student->user->email); ?>" readonly>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Заметка об ученике</span>
                            <input id="name" type="text" class="field" name="note" value="<?php echo e($student->note); ?>" autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Сообщение ученику</span>
                            <textarea class="field" name="message" spellcheck="false"><?php echo e($student->message); ?></textarea>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Группа</span>
                            <select name="group_id" id="userGroupSelect" data-url="<?php echo e(route('teacher.update_student', ['student_id' => $student->id])); ?>" class="js-select" style="width: 100%;">
                                <option value="<?php echo e($student->group->id); ?>"><?php echo e($student->group->name); ?></option>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </label>
                    </div>
                    <input type="hidden" name="student_id" value="<?php echo e($student->id); ?>">
                    <div class="col l12 s12">
                        <button type="submit" name="button" class="btn">
                            <span>Сохранить</span>
                        </button>
                    </div>
                    <div class="col l12 s12">
                        <?php $__env->startComponent('components.student_stats', ['student' => $student, 'container' => true]); ?>
                        <?php echo $__env->renderComponent(); ?>
                    </div>
                </div>
                <?php echo Form::close(); ?>

            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>