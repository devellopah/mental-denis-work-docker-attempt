<?php $__env->startSection('content'); ?>

    <main class="pdg groups" id="app">
        <div class="container">
            <div class="block-bg">
                <div class="block-decor block-decor--title">
                    <div class="block-decor__in">
                        <h1 class="title">Статистика</h1>
                    </div>
                </div>
                <div class="users-table users-table--mrg">
                    <div class="row">
                        <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php echo Form::open(['url'=>url('/users/stats'), 'method' => 'get']); ?>

                        <div class="col l4 m6 s12">
                            <label>
                                <span class="label">Группа</span>
                                <select name="stat_id" class="js-select groups_select" style="width: 100%;">
                                    <option value="all">Общая</option>
                                    <option value="numbers">Ментальный счёт</option>
                                    <option value="rombs">Флеш-карты</option>
                                </select>
                            </label>
                        </div>
                        <div id="all" class="tab-pane active">
                            <table class="flex-table data-table" id="stats_list">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Имя</th>
                                    <th>кол-во ответов</th>
                                    <th>верные ответы</th>
                                    <th>неверные ответы</th>
                                    <th>успеваемость</th>
                                    <th>рейтинг</th>
                                </tr>
                                </thead>
                                <tbody class="js-scroll">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(empty($i) ? $i = 1 : $i = $i + 1); ?></td>
                                        <td>
                                            <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                                                <img src="/images/avatars/<?php echo e($user->avatar); ?>" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">
                                            </a>
                                            <a href="<?php echo e(url("/user/$user->id")); ?>"><?php echo e($user->name); ?></a>
                                        </td>
                                        <td><?php echo e($user->student['all']['answers_total']); ?></td>
                                        <td><?php echo e($user->student['all']['answers_correct']); ?></td>
                                        <td><?php echo e($user->student['all']['answers_wrong']); ?></td>
                                        <td><?php echo e($user->student['all']['answers_accuracy']); ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="numbers" class="tab-pane">
                            <table class="flex-table data-table" id="stats_list">
                                <thead>
                                <tr>
                                    <th>№</th>
                                    <th>Имя</th>
                                    <th>кол-во ответов</th>
                                    <th>верные ответы</th>
                                    <th>неверные ответы</th>
                                    <th>успеваемость</th>
                                    <th>рейтинг</th>
                                </tr>
                                </thead>
                                <tbody class="js-scroll">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(empty($k) ? $k = 1 : $k = $k + 1); ?></td>
                                        <td>
                                            <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                                                <img src="/images/avatars/<?php echo e($user->avatar); ?>" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">
                                            </a>
                                            <a href="<?php echo e(url("/user/$user->id")); ?>"><?php echo e($user->name); ?></a>
                                        </td>
                                        <td><?php echo e($user->student['numbers']['answers_total']); ?></td>
                                        <td><?php echo e($user->student['numbers']['answers_correct']); ?></td>
                                        <td><?php echo e($user->student['numbers']['answers_wrong']); ?></td>
                                        <td><?php echo e($user->student['numbers']['answers_accuracy']); ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="rombs" class="tab-pane">
                            <table class="flex-table data-table" id="stats_list">
                                <thead>
                                <tr>
                                    <th class="text-left">№</th>
                                    <th class="text-left">Имя</th>
                                    <th class="text-left">кол-во ответов</th>
                                    <th class="text-left">верные ответы</th>
                                    <th class="text-left">неверные ответы</th>
                                    <th class="text-left">успеваемость</th>
                                    <th class="text-left">рейтинг</th>
                                </tr>
                                </thead>
                                <tbody class="js-scroll">
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(empty($t) ? $t = 1 : $t = $t + 1); ?></td>
                                        <td>
                                            <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                                                <img src="/images/avatars/<?php echo e($user->avatar); ?>" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">
                                            </a>
                                            <a href="<?php echo e(url("/user/$user->id")); ?>"><?php echo e($user->name); ?></a>
                                        </td>
                                        <td><?php echo e($user->student['rombs']['answers_total']); ?></td>
                                        <td><?php echo e($user->student['rombs']['answers_correct']); ?></td>
                                        <td><?php echo e($user->student['rombs']['answers_wrong']); ?></td>
                                        <td><?php echo e($user->student['rombs']['answers_accuracy']); ?></td>
                                        <td></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if(\Auth::user()->rang === 'A'): ?>
                        <div class="col l12 s12">
                            <button type="submit" name="button" class="btn">
                                <span>Обновить</span>
                            </button>
                        </div>
                        <?php endif; ?>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </main>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>