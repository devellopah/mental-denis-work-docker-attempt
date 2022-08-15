<?php $__env->startSection('content'); ?>

    <main class="pdg" id="app">
        <div class="container">
            <div class="block-bg users_list">
                <div class="block-decor block-decor--title">
                    <div class="block-decor__in">
                        <h1 class="title">Список пользователей</h1>
                    </div>
                </div>
                <div class="btns">
                    <a href="#" class="btn-blue icon-arrow-back on-desktop"><span></span></a>
                    <?php if(\Auth::user()->rang === config('rang.admin')): ?>
                        <a href="<?php echo e(url('/user/create')); ?>" class="btn-blue icon-add"><span></span></a>
                    <?php endif; ?>
                </div>
                <div class="users-table users-table--mrg">
                    <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                    <?php echo Form::open(['url'=>url('/users')]); ?>


                    <table class="flex-table valign-middle data-table" id="users_list">
                        <thead>
                        <tr>
                            <th>Пользователь</th>
                            <th><div class="sort">Активация</div></th>
                            <th><div class="sort sort--up">Осталось</div></th>
                            <th><div class="sort sort--up">Статус</div></th>
                            <th><div class="sort sort--up">E-mail</div></th>
                            <?php if(\Auth::user()->rang === 'A'): ?>
                                <th>Удалить</th>
                            <?php endif; ?>
                        </tr>
                        </thead>
                        <tbody class="js-scroll">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                                        <img class="student__img" src="/images/avatars/<?php echo e($user->avatar); ?>" alt="">
                                    </a>
                                    <a class="student__name" href="<?php echo e(url('/user/' . $user->id)); ?>"><?php echo e($user->name); ?></a>
                                </td>
                                <td><?php if($user->rang == 'F'): ?> <span class="inact">Неактивен</span> <?php else: ?> <span class="act">Активен</span> <?php endif; ?></td>
                                <td>3 дня</td>
                                <td><?php echo e(config('rang.' . $user->rang)); ?></td>
                                <td><?php echo e($user->email); ?></td>
                                <?php if(\Auth::user()->rang === 'A'): ?>
                                    <td>
                                        <label class="switch switch--sm">
                                            <input class="switch_checkbox" type="checkbox" <?php if($user->rang != 'F'): ?> checked <?php endif; ?>>
                                            <span class="switch__bar"></span>
                                            <input type="hidden" name="changeRang[<?php echo e($user->id); ?>]" value="<?php if($user->rang != 'F'): ?> active <?php else: ?> noactive <?php endif; ?>" >
                                        </label>
                                    <a class="delete delete-link" title="Удалить"></a>
                                    <?php echo Form::checkbox('removeUser['. $user->id .']', $user->id, false, ['class'=>'remove_checkbox']); ?>

                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot>
                    </table>
                    <?php if(\Auth::user()->rang === 'A'): ?>
                        <div class="col l12 s12 text-center">
                            <button type="submit" name="button" class="btn"><span>Обновить</span></button>
                        </div>
                    <?php endif; ?>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>