<?php $__env->startSection('content'); ?>

        <main class="pdg groups" id="app">
            <div class="container">
                <div class="block-bg">
                    <div class="block-decor block-decor--title">
                        <div class="block-decor__in">
                            <h1 class="title">Список групп</h1>
                        </div>
                    </div>
                    <div class="btns">
                        <a href="<?php echo e(route('teacher.add_student')); ?>" class="btn-blue icon-add" title="Добавить ученика"><span></span></a>
                    </div>
                    <div class="users-table users-table--mrg">
                        <?php if (! ($groups->count())): ?>

                            <h4>Вы ещё не создали ни одной группы</h4>

                            <div class="row">
                                <div class="col l12 s12">
                                    <a class="btn btn--sm add_group" href="<?php echo e(route('teacher.create_group')); ?>"><span>Добавить группу</span></a>
                                </div>
                            </div>

                            <?php else: ?>
                                <div class="row">
                                    <div class="col l4 m6 s12">
                                        <label>
                                            <span class="label">Группа</span>
                                            <select name="group_id" class="js-select groups_select" style="width: 100%;">
                                                <option value="all">Все ученики</option>
                                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="group<?php echo e($group->id); ?>"><?php echo e($group->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </label>
                                    </div>
                                    <div class="col l12 s12 add_group text-center">
                                        <a class="btn btn--sm add_group" href="<?php echo e(route('teacher.create_group')); ?>"><span>Добавить группу</span></a>
                                        <a class="btn btn--sm add_group" href="<?php echo e(route('teacher.add_student')); ?>"><span>Добавить ученика</span></a>
                                    </div>
                                </div>

                                <div id="all" class="tab-pane active">
                                    <table class="flex-table data-table">
                                        <thead>
                                        <tr>
                                            <th>Пользователь</th>
                                            <th><div class="sort">Кол-во ответов</div></th>
                                            <th><div class="sort sort--up">Верные ответы</div></th>
                                            <th><div class="sort sort--up">Неверные ответы</div></th>
                                            <th><div class="sort sort--up">Успеваемость</div></th>
                                            <th>Рейтинг</th>
                                        </tr>
                                        </thead>
                                        <tbody class="js-scroll">
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <a href="#" data-featherlight="/images/avatars/<?php echo e($student->user->avatar); ?>">
                                                        <img class="student__img" src="/images/avatars/<?php echo e($student->user->avatar); ?>" alt="">
                                                    </a>
                                                    <a class="student__name" href="<?php echo e(route('teacher.student', ['student_id' => $student->id])); ?>"><?php echo e($student->user->name); ?></a>
                                                </td>
                                                <td><?php echo e($student['all']['answers_total']); ?></td>
                                                <td><?php echo e($student['all']['answers_correct']); ?></td>
                                                <td><?php echo e($student['all']['answers_wrong']); ?></td>
                                                <td><?php echo e($student['all']['answers_accuracy']); ?></td>
                                                <td></td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                        <tfoot>
                                    </table>
                                </div>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div id="group<?php echo e($group->id); ?>" class="tab-pane">
                                        <?php if($group->students->isEmpty()): ?>
                                            <h4>В этой группе нет еще учеников</h4>
                                        <?php else: ?>
                                            <table class="flex-table data-table">
                                                <thead>
                                                <tr>
                                                    <th>Пользователь</th>
                                                    <th><div class="sort">Кол-во ответов</div></th>
                                                    <th><div class="sort sort--up">Верные ответы</div></th>
                                                    <th><div class="sort sort--up">Неверные ответы</div></th>
                                                    <th><div class="sort sort--up">Успеваемость</div></th>
                                                    <th>Рейтинг</th>
                                                </tr>
                                                </thead>
                                                <tbody class="js-scroll">
                                                <?php $__currentLoopData = $group->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <a href="#" data-featherlight="/images/avatars/<?php echo e($student->user->avatar); ?>">
                                                                <img class="student__img" src="/images/avatars/<?php echo e($student->user->avatar); ?>" alt="">
                                                            </a>
                                                            <a class="student__name" href="<?php echo e(route('teacher.student', ['student_id' => $student->id])); ?>"><?php echo e($student->user->name); ?></a>
                                                        </td>
                                                        <td><?php echo e($student['all']['answers_total']); ?></td>
                                                        <td><?php echo e($student['all']['answers_correct']); ?></td>
                                                        <td><?php echo e($student['all']['answers_wrong']); ?></td>
                                                        <td><?php echo e($student['all']['answers_accuracy']); ?></td>
                                                        <td></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>

                                            <table class="table table-striped valign-middle">
                                                <thead>
                                                <tr>
                                                    <th class="text-left">Тема</th>
                                                    <th class="text-left">Уровень</th>
                                                    <th class="text-left">ДЗ</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-left"><?php echo e($group->theme); ?></td>
                                                    <td class="text-left"><?php echo e($group->level); ?></td>
                                                    <td class="text-left">
                                                        <a href="<?php echo e(route('group.tasks', ['group_id' => $group->id])); ?>">
                                                            <span class="group-prop-text">Настройки</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                            <?php endif; ?>
                                            <div>
                                                <form action="<?php echo e(route('teacher.delete_group', ['group_id' => $group->id])); ?>" method="post">
                                                    <?php echo e(csrf_field()); ?>

                                                    <button id="groupRemove" class="btn btn--sm" type="submit"><span>Удалить группу</span></button>
                                                </form>
                                            </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>

        <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>