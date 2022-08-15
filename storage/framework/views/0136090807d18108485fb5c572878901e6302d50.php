<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="page-top">
            <h3 class="page-header">Оплата прошла успешно</h3>
        </div>
        <div class="row clearfix">
            <div class="col-md-6">
                <a href="/user/profile/" class="btn btn-raised btn-danger btn-md">Перейти в профиль</a>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>