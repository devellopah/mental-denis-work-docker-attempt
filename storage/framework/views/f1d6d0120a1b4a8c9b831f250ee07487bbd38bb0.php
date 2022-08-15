<?php $__env->startSection('content'); ?>


    <main class="main">
        <div class="trs valign">
            <div class="container">
                <h1 class="trs__title">Выберите тренажёр</h1>
                <div class="trs__list js-mobile-slider">
                    <div class="trs__list-item">
                        <a href="<?php echo e(url('/trainers/1/categories')); ?>" class="trainer" title="">
                            <span class="trainer__img trainer__img--ansan"></span>
                            <span class="trainer__name">Флеш-анзан</span>
                        </a>
                    </div>
                    <div class="trs__list-item">
                        <a href="<?php echo e(url('/trainers/2/categories')); ?>" class="trainer" title="">
                            <span class="trainer__img trainer__img--cards"></span>
                            <span class="trainer__name">Флеш-карты</span>
                        </a>
                    </div>
                    <div class="trs__list-item">
                        <a href="/columns.html" class="trainer" title="">
                            <span class="trainer__img trainer__img--columns"></span>
                            <span class="trainer__name">Столбцы</span>
                        </a>
                    </div>
                    <div class="trs__list-item">
                        <a href="/multiply.html" class="trainer" title="">
                            <span class="trainer__img trainer__img--multiply"></span>
                            <span class="trainer__name">умножайка</span>
                        </a>
                    </div>
                    <?php if(\Auth::user()['rang'] == config('rang.admin')): ?>
                        <div class="trs__list-item">
                            <a href="<?php echo e(url('/generator')); ?>" class="trainer" title="">
                                <span class="trainer__img trainer__img--generator"></span>
                                <span class="trainer__name">Генератор</span>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

<?php if($isExecutor): ?>

<!-- <div class="welcome-wrapper">
    <div class="welcome-block welcome-block--left">
        <div class="welcome-block__jumbo" style="background-image: url(<?php echo e(asset('images/welcome_jumbo_left.png')); ?>);">
            <span>Привет, Академик!</span><br><br>
            <span>Хочу тебе напомнить,</span>
            <span>что ежедневные</span><br>
            <span>занятия очень важны,</span><br>
            <span>выполняй своё домашнее</span><br>
            <span>задание по расписанию</span><br><br>
            <span>Удачи!</span>

        </div>
        <img src="<?php echo e(asset('images/welcome_student.png')); ?>" alt="img" class="welcome-block__character">
    </div>

    <div class="welcome-block welcome-block--right">
        <div class="welcome-block__jumbo" style="background-image: url(<?php echo e(asset('images/welcome_jumbo_right.png')); ?>);">
            <span>Добро пожаловать,</span><br>
            <span>наш юный Академик!</span><br><br>

            <span>Если ты на нашем</span><br>
            <span>образовательном портале,</span><br>
            <span>то ты готов не на шутку развиваться</span><br>
            <span>и побеждать! Мы уверены,</span><br>
            <span>что все дети изначально имеют</span><br>
            <span>замечательные способности,</span><br>
            <span>и при правильных занятиях</span><br>
            <span>каждый может достигать</span><br>
            <span>отличных результатов,</span><br>
            <span>а учёба при этом может</span><br>
            <span>приносить радость.</span><br><br>

            <span>Желаем тебе успехов!</span><br>
        </div>
        <img src="<?php echo e(asset('images/welcome_teacher.png')); ?>" alt="img" class="welcome-block__character">

    </div>

    <div class="user-menu">
        <ul class="user-menu__list list-unstyled mb-0">
            <?php $__currentLoopData = $userMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="user-menu__item<?php echo e(Request::route()->getName() == $item['name'] ? ' active' : ''); ?>">
                <a class="user-menu__link" href="<?php echo e($item['route']); ?>"><?php echo e($item['title']); ?></a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
</div>

<?php else: ?>
    <div class="user-menu" style="padding: 30px 15px;">
        <ul class="user-menu__list list-unstyled mb-0">
            <?php $__currentLoopData = $userMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="user-menu__item<?php echo e(Request::route()->getName() == $item['name'] ? ' active' : ''); ?>">
                <a class="user-menu__link" href="<?php echo e($item['route']); ?>"><?php echo e($item['title']); ?></a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?> -->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>