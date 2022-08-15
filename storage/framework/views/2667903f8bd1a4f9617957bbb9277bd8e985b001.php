<?php $__env->startSection('content'); ?>
    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a class="btn-blue"><span></span><b>Тарифы</b></a>
                        </div>
                    </div>
                </div>
                <div class="row login-form">
                    <?php $__currentLoopData = $tariffs->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tariff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col l4 m6 s12 text-center tariff">
                            <p class="text-muted">
                                <strong>Описание:</strong> <?php echo e($tariff->description); ?>

                            </p>
                            <p><strong>Срок:</strong> <?php echo e($tariff->duration); ?> дней</p>
                            <p><strong>Стоимость:</strong> <?php echo e($tariff->cost); ?> рублей</p>
                            <?php if(\Auth::user()->rang === 'A'): ?>
                                <p>
                                    <a href="<?php echo e(url("payment/tariffs/$tariff->id")); ?>" class="btn"><span>Редактировать</span></a>
                                    <a href="<?php echo e(url("payment/tariffs/$tariff->id/delete")); ?>" class="btn"><span>Удалить</span></a>
                                    <a href="<?php echo e(url("payment/$tariff->id/process")); ?>" class="btn"><span>Оплатить</span></a>
                                </p>
                            <?php else: ?>
                                <p><a href="<?php echo e(url("payment/$tariff->id/process")); ?>" class="btn"><span>Оплатить</span></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if(\Auth::user()->rang === 'A'): ?>
                            <div class="col s12 text-center">
                                <a href="<?php echo e(url("/payment/tariffs/new")); ?>" class="btn"><span>Добавить новый</span></a>
                                <a href="<?php echo e(url("/payment/stat")); ?>" class="btn"><span>Все платежи</span></a>
                            </div>
                        <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>