<?php $__env->startSection('content'); ?>

    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a class="btn-blue"><span></span><b><?php echo e($tariff->name); ?> | Редактировать</b></a>
                        </div>
                    </div>
                </div>
                <div class="row add_tariff">
                    <?php echo Form::open(array('url' => 'payment/tariffs/'.$tariff->id)); ?>

                    <?php if( $messages['text'] != ''): ?>
                        <div class="row clearfix">
                            <div class="col-md-6">
                                <p class="bg-<?php echo e($messages['code']); ?>"><?php echo e($messages['text']); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Название</span>
                            <input type="text" class="field" name="name" value="<?php echo e($tariff->name); ?>" required autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Описание</span>
                            <textarea class="field" name="description"><?php echo e($tariff->description); ?></textarea>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Продолжительность (дней)</span>
                            <input type="text" class="field" name="duration" value="<?php echo e($tariff->duration); ?>" required autofocus>
                        </label>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">Стоимость (рублей)</span>
                            <input type="text" class="field" name="cost" value="<?php echo e($tariff->cost); ?>" required autofocus>
                        </label>
                    </div>
                    <div class="col s12 text-center">
                        <button type="submit" name="button" class="btn">
                            <span>Изменить</span>
                        </button>
                        <a class="btn" href="<?php echo e(url('/payment/tariffs')); ?>">
                            <span>Назад к тарифам</span>
                        </a>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>