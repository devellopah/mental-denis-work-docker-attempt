<?php $__env->startSection('content'); ?>

    <div class="View">
        <div class="View__head">

            <div class="container">
                <div class="row text-center">

                    <div class="col-sm-5 text-sm-left">
                        <h2 class="View__title mb-sm-0">
                            Список заданий
                        </h2>
                    </div>

                    <div class="col-sm-7 text-sm-right">
      
                    </div>

                </div>
            </div>

        </div>

        <div class="View__body">

            <div class="container">

                <div class="row">

                    <div class="col-sm-4 col-md-3" style="padding-bottom: 40px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#group" class="stats-header">Групповые</a></li>
                            <li><a data-toggle="tab" href="#student" class="stats-header">Индивидуальные</a></li>
                        </ul>
                    </div>

                    <div class="col-sm-8 col-md-9">

                        <div class="tab-content" style="flex-grow: 1;">
                            <div id="group" class="tab-pane fade in active">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#group_active" class="stats-header">активные</a></li>
                                    <li><a data-toggle="tab" href="#group_finished" class="stats-header">завершённые</a></li>
                                </ul>

                                <div class="tab-content" style="flex-grow: 1;">
                                    <div id="group_active" class="tab-pane fade in active">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">Успеваемость</th>                   
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $__currentLoopData = $group_tasks_active; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                                    <tr valign="middle" class="">
                                                        <td class="text-left">
                                                            <a href="<?php echo e(route('student.tasks.group_task', [
                                                            'student_id' => $student->id,
                                                            'group_task_id' => $task->id
                                                        ])); ?>" class="btn">Начать</a>
                                                        </td>
                                                        <td class="text-left"><?php echo e($task->trainer_name); ?></td>

                                                        <?php if( !is_null( json_decode($task->req_formulas) ) ): ?>
                                                        <td class="text-left">
                                                            <p>Уровень - <?php echo e($task->level); ?></p>
                                                            <p>Слагаемых - <?php echo e($task->nums); ?></p>
                                                            <p>Примеров - <?php echo e($task->quantity); ?></p>
                                                            <?php if( count( json_decode($task->req_formulas) ) ): ?>
                                                                <p><span>Обяз. формулы : </span></p>
                                                                <?php $__currentLoopData = json_decode($task->req_formulas); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <strong><?php echo e($formula); ?></strong>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            <?php endif; ?>
                                                            <p><span>вычитание - </span><?php echo e($task->subtraction ? 'да' : 'нет'); ?></p>  
                                                        </td>
                                                        <?php else: ?>
                                                        <td class="text-left">
                                                            <p>Диапазон - <?php echo e($task->minmax); ?></p>
                                                            <p>Кол-во чисел - <?php echo e($task->quantity); ?></p>
                                                        </td>
                                                        <?php endif; ?>
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>  
                                                    </tr>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="group_finished" class="tab-pane fade">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">успеваемость</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $__currentLoopData = $group_tasks_finished; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr valign="middle" class="">
                                                        <td class="text-left"><?php echo e($task->pivot->started_time); ?></td>
                                                        <td class="text-left"><?php echo e($task->trainer_name); ?></td>

                                                        <?php if( !is_null( json_decode($task->req_formulas) ) ): ?>
                                                        <td class="text-left">
                                                            <p>Уровень - <?php echo e($task->level); ?></p>
                                                            <p>Слагаемых - <?php echo e($task->nums); ?></p>
                                                            <p>Примеров - <?php echo e($task->quantity); ?></p>
                                                            <?php if( count( json_decode($task->req_formulas) ) ): ?>
                                                                <p><span>Обяз. формулы : </span></p>
                                                                <?php $__currentLoopData = json_decode($task->req_formulas); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <strong><?php echo e($formula); ?></strong>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            <?php endif; ?>
                                                            <p><span>вычитание - </span><?php echo e($task->subtraction ? 'да' : 'нет'); ?></p>  
                                                        </td>
                                                        <?php else: ?>
                                                        <td class="text-left">
                                                            <p>Диапазон - <?php echo e($task->minmax); ?></p>
                                                            <p>Кол-во чисел - <?php echo e($task->quantity); ?></p>
                                                        </td>
                                                        <?php endif; ?>
                                                        
                                                        <td class="text-left">
                                                            <p><?php echo e($task->pivot->lead_time); ?></p>
                                                            
                                                        </td>
                                                        <td class="text-left"><?php echo e($task->pivot->accuracy); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div id="student" class="tab-pane fade">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#student_active" class="stats-header">активные</a></li>
                                    <li><a data-toggle="tab" href="#student_finished" class="stats-header">завершённые</a></li>
                                </ul>

                                <div class="tab-content" style="flex-grow: 1;">
                                    <div id="student_active" class="tab-pane fade in active">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">Успеваемость</th>    
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $__currentLoopData = $student_tasks_active; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        
                                                    <tr valign="middle" class="">
                                                        <td class="text-left">
                                                            <a href="<?php echo e(route('student.tasks.student_task', [
                                                            'student_id' => $student->id,
                                                            'student_task_id' => $task->id
                                                        ])); ?>" class="btn">Начать</a>
                                                        </td>
                                                        <td class="text-left"><?php echo e($task->trainer_name); ?></td>
                                                        <?php if( !is_null( json_decode($task->req_formulas) ) ): ?>
                                                        <td class="text-left">
                                                            <p>Уровень - <?php echo e($task->level); ?></p>
                                                            <p>Слагаемых - <?php echo e($task->nums); ?></p>
                                                            <p>Примеров - <?php echo e($task->quantity); ?></p>
                                                            <?php if( count( json_decode($task->req_formulas) ) ): ?>
                                                                <p><span>Обяз. формулы : </span></p>
                                                                <?php $__currentLoopData = json_decode($task->req_formulas); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <strong><?php echo e($formula); ?></strong>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            <?php endif; ?>
                                                            <p><span>вычитание - </span><?php echo e($task->subtraction ? 'да' : 'нет'); ?></p>  
                                                        </td>
                                                        <?php else: ?>
                                                        <td class="text-left">
                                                            <p>Диапазон - <?php echo e($task->minmax); ?></p>
                                                            <p>Кол-во чисел - <?php echo e($task->quantity); ?></p>
                                                        </td>
                                                        <?php endif; ?>
                                                        <td class="text-left"></td>
                                                        <td class="text-left"></td>
                                                    </tr>

                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="student_finished" class="tab-pane fade">
                                        <div class="table-overflow container-fluid">
                                            <table class="table table-striped valign-middle data-table">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">Старт</th>
                                                        <th class="text-left">Тренажёр</th>
                                                        <th class="text-left">Параметры</th>
                                                        <th class="text-left">Выполнение</th>
                                                        <th class="text-left">успеваемость</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php $__currentLoopData = $student_tasks_finished; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr valign="middle" class="">
                                                        <td class="text-left"><?php echo e($task->started_time); ?></td>
                                                        <td class="text-left"><?php echo e($task->trainer_name); ?></td>

                                                        <?php if( !is_null( json_decode($task->req_formulas) ) ): ?>
                                                        <td class="text-left">
                                                            <p>Уровень - <?php echo e($task->level); ?></p>
                                                            <p>Слагаемых - <?php echo e($task->nums); ?></p>
                                                            <p>Примеров - <?php echo e($task->quantity); ?></p>
                                                            <?php if( count( json_decode($task->req_formulas) ) ): ?>
                                                                <p><span>Обяз. формулы : </span></p>
                                                                <?php $__currentLoopData = json_decode($task->req_formulas); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $formula): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <strong><?php echo e($formula); ?></strong>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php else: ?>
                                                                <p><span>Обяз. формулы - нет </span></p>
                                                            <?php endif; ?>
                                                            <p><span>вычитание - </span><?php echo e($task->subtraction ? 'да' : 'нет'); ?></p>  
                                                        </td>
                                                        <?php else: ?>
                                                        <td class="text-left">
                                                            <p>Диапазон - <?php echo e($task->minmax); ?></p>
                                                            <p>Кол-во чисел - <?php echo e($task->quantity); ?></p>
                                                        </td>
                                                        <?php endif; ?>

                                                        <td class="text-left">
                                                            <p><?php echo e($task->lead_time); ?></p>
                                                            
                                                        </td>
                                                        <td class="text-left"><?php echo e($task->accuracy); ?></td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>