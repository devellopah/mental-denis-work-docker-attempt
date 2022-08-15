<?php $__env->startSection('content'); ?>
    <main id="app" class="pdg">
        <div class="container">
            <div class="block-bg">
                <div class="row reset-form text-center">
                    <div class="btns on-desktop">
                        <a href="#" class="btn-blue"><span></span><b>Восстановить пароль</b></a>
                    </div>
                    <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                    <?php endif; ?>
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/password/email')); ?>">
                        <?php echo e(csrf_field()); ?>

                        <div class="col l4 m6 s12 text-center<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                            <label>
                                <span class="label">Email</span>
                                <input id="email" type="email" class="field" name="email" value="<?php echo e(old('email')); ?>" required>
                            </label>
                            <?php if($errors->has('email')): ?>
                                <span class="help-block">
                        <strong><?php echo e($errors->first('email')); ?></strong>
                    </span>
                            <?php endif; ?>
                        </div>
                        <div class="col s12 text-center">
                            <button type="submit" name="button" class="btn">
                                <span>Выслать пароль</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>