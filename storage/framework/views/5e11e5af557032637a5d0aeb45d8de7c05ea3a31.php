<main id="app" class="pdg">
    <div class="container">
        <div class="block-bg">
            <div class="row reset-form text-center" id="groupContainer">
                <div class="btns on-desktop">
                    <a href="#" class="btn-blue"><span></span><b>Добавление группы</b></a>
                </div>
                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                { <?php echo Form::open(); ?>

                <?php echo e(csrf_field()); ?>

                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col l4 m6 s12 text-center <?php echo e($errors->has('name') ? ' has-error' : ''); ?>">
                    <label>
                        <span class="label">Название группы</span>
                        <input id="name" type="text" class="field" name="name" value="<?php echo e(old('name')); ?>" required autofocus>
                        <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                </span>
                        <?php endif; ?>
                    </label>
                </div>
                <div class="col l4 m6 s12 text-center">
                    <label>
                        <span class="label">Тема</span>
                        <?php echo Form::select('theme', [], null, ['class'=>'js-select', 'style' => 'width: 100%;']); ?>

                    </label>
                </div>
                <div class="col l4 m6 s12 text-center">
                    <label>
                        <span class="label">Уровень</span>
                        <?php echo Form::select('level', [], null, ['class'=>'js-select', 'style' => 'width: 100%;']); ?>

                    </label>
                </div>
                <div class="col l12 s12">
                    <button type="submit" name="button" class="btn">
                        <span>Создать</span>
                    </button>
                </div>

                <?php echo e(Form::hidden('user_id', auth()->user()->id)); ?>


                <?php echo Form::close(); ?>

            </div>
        </div>
    </div>
</main>

