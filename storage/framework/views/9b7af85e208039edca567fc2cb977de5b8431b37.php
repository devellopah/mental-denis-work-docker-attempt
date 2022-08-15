<?php $__env->startSection('content'); ?>

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">
                            Список категорий
                        </h2>
                    </div>

                    <?php if(\Auth::user()['rang'] == config('rang.admin')): ?>
                        <div class="col-sm-7 text-sm-right">
                            <div class="View__headActions">
                            <a class="View__createCat" href="<?php echo e(route('trainers.categories.create', $trainer_id)); ?>" class="">Добавить категорию</a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>

        <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <div class="View__body">

            <div class="container">
                <div class="row">

                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="View__card" style="min-height: 325px">
                                <h4 class="View__cardTitle">
                                    <span><?php echo e(++$index); ?></span>
                                    <span style="padding-bottom: 6px;">Уровень</span>
                                    <span><?php echo e($category->name); ?></span>
                                </h4>
                                <div class="View__cardActions">

                                    <a class="View__cardReview" href="<?php echo e(url("/trainers/$trainer_id/categories/$category->id/exercises")); ?>">
                                        Просмотр
                                    </a>

                                    <?php if(\Auth::user()['rang'] == config('rang.admin')): ?>
                                        <a class="View__cardEdit"
                                           href="<?php echo e(url("/trainers/$trainer_id/categories/$category->id/edit")); ?>">
                                            Редактировать
                                        </a>
                                        <button
                                                data-action="/trainers/<?php echo e($trainer_id); ?>/categories/<?php echo e($category->id); ?>"
                                                class="View__cardDelete delete-btn-modal-js">
                                            Удалить
                                        </button>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>