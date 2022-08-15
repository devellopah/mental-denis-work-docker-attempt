<?php $__env->startSection('content'); ?>

    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div class="row reset-form text-center">
                    <div class="btns on-desktop">
                        <span class="btn-blue"><span></span><b>Добавление ученика в группу</b></span>
                    </div>
                    <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo Form::open(); ?>

                    <?php echo e(csrf_field()); ?>

                        <div class="col l4 m6 s12 text-center">
                            <label>
                                <span class="label">Группы</span>
                                <?php echo Form::select('group_id', $groups, null, ['class'=>'js-select', 'style' => 'width: 100%;']); ?>

                            </label>
                        </div>
                        <div class="col l4 m6 s12 text-center">
                            <label>
                                <span class="label">Студенты</span>
                                <?php echo Form::select('user_id', $users, null, ['class'=>'js-select', 'style' => 'width: 100%;']); ?>

                            </label>
                        </div>
                    <div class="col l12 s12">
                        <button type="submit" name="button" class="btn">
                            <span>Добавить в группу</span>
                        </button>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>