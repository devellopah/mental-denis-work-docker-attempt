<?php $__env->startSection('content'); ?>

    <main class="pdg">
        <div class="container">
            <div class="block-bg profile">
                <div class="user-photo on-desktop">
                    <a href="#" data-featherlight="/images/avatars/<?php echo e($user->avatar); ?>">
                        <img src="/images/avatars/<?php echo e($user->avatar); ?>" alt="">
                    </a>
                </div>
                <div class="acc__btns btns">
                    <?php if(\Auth::user()->rang === 'A'): ?>
                        <?php echo Form::open(['url'=>url('/users')]); ?>

                        <button class="btn-blue icon-del delete-link" title="Удалить пользователя"><span></span></button>
                        <?php echo Form::checkbox('removeUser['. $user->id .']', $user->id, false, ['class'=>'remove_checkbox']); ?>

                        <?php echo Form::close(); ?>

                    <?php endif; ?>
                </div>
                <?php echo Form::open(['files' => true]); ?>


                <?php if(\Auth::user()->rang === 'A'): ?>
                <div class="acc__top">
                    <div class="acc__top-right">
                        <span class="label label--inline">Активация</span>
                        <label class="switch">
                            <input type="checkbox" name="rang" class="switch_checkbox"<?php if($user->rang != 'F'): ?> checked <?php endif; ?>>
                            <span class="switch__bar"></span>
                        </label>
                    </div>
                </div>
                <?php endif; ?>
                <?php if($errors->any()): ?>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="alert alert-danger"><?php echo e($error); ?></div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                <?php echo $__env->make('common.messages', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="row">
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">ФИО</span>
                            <input type="text"  id="name" name="name" class="field" value="<?php echo e($user->name); ?>" />
                        </label>
                        <?php if($errors->has('name')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('name')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col l4 m6 s12">
                        <label>
                            <span class="label">E-mail</span>
                            <input name="email" type="email" value="<?php echo e($user->email); ?>" id="email" class="field">
                        </label>
                        <?php if($errors->has('email')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col l4 m6 s12">
                        <div class="pos-rel">
                            <label>
                                <span class="label">Пароль</span>
                                <input name="password" type="password" value="" id="password" class="field">
                            </label>
                            <span class="icon-pass js-pass-toggle"></span>
                        </div>
                        <?php if($errors->has('password')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col l4 m6 s12">
                        <div class="pos-rel">
                            <label>
                                <span class="label">Подверждение пароля</span>
                                <input name="password_confirmation" type="password" value="" id="password_confirmation" class="field">
                            </label>
                            <span class="icon-pass js-pass-toggle"></span>
                        </div>
                        <?php if($errors->has('password_confirmation')): ?>
                            <span class="help-block">
                                <strong><?php echo e($errors->first('password_confirmation')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col l12 s12 text-center">
                        <button type="submit" name="button" class="btn"><span>Сохранить</span></button>
                        <label for="avatar" id="profileAvatarRefresher" class="btn profile-form__label--avatar">
                            Обновить аватарку
                        </label>
                        <input id="avatar" placeholder="Обновить аватарку" name="avatar" type="file" class="hide">
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>