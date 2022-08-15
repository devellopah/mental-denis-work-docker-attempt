<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="page-top">
            <h3 class="page-header">Список пользователей</h3>
            <?php if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin')): ?>
            <a class="add-user-link" href="<?php echo e(url('/user/create')); ?>">
                <span>Добавить пользователя</span>
            </a>
            <?php endif; ?>
        </div>

        <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo Form::open(['url'=>url('/users')]); ?>

        <table class="table table-striped valign-middle data-table">
            <thead>
            <tr>
                <th class="text-left">№</th>
                <th class="text-left">Имя</th>
                <th align="left" class="text-left">Email</th>
                <th align="left" class="text-left">Ранг</th>
                <?php if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin')): ?>
                    
                    
                    <th class="text-center">Удалить</th>
                <?php endif; ?>

            </tr>
            </thead>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr valign="middle" class="<?php echo e($user->rang === config('rang.not_confirmed') ? 'danger' : ''); ?>">
                    <td class="text-left"><?php echo e(empty($i) ? $i = 1 : $i = $i + 1); ?></td>
                    <td class="text-left text-left--flex">
                            <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                                <img src="/images/avatars/<?php echo e($user->avatar); ?>" alt="avatar" style="max-width: 30px; border-radius: 50%; margin-right: 8px;">                     
                            </a>
                        <a href="<?php echo e(url('/user/' . $user->id)); ?>"><?php echo e($user->name); ?></a>
                    </td>
                    <td class="text-left"><?php echo e($user->email); ?></td>
                    <td class="text-left"><?php echo e(config('rang.' . $user->rang)); ?></td>
                    <?php if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin')): ?>
                        
                        

                        <td align="center">
                            <div class="checkbox">
                                <label>
                                    <?php echo Form::checkbox('removeUser['. $user->id .']', $user->id, false, ['class'=>'']); ?>

                                    <span class="checkbox-material"></span>
                                </label>
                            </div>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
        <?php if( \Auth::user()->rang === config('rang.creator') || \Auth::user()->rang === config('rang.admin')): ?>
            <div class="float-right clearfix">
                <div class="form-group clearfix col-md-12">
                    <?php echo Form::submit('Обновить', ['class'=>'btn btn-raised btn-danger btn-lg']); ?>

                </div>
            </div>
        <?php endif; ?>
        <?php echo Form::close(); ?>

        
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>