<main id="app" class="pdg">
    <div class="container">
        <div class="block-bg">
            <?php if (! (count($errors))): ?>
                <div id="rolePickerOverlay" class="role-picker-overlay">
                    <div class="role-picker">
                        <div class="btns on-desktop">
                            <a href="#" class="btn-blue"><span></span><b>Выберите роль</b></a>
                        </div>
                        <div class="row">
                            <div class="col s12 text-center">
                                <button type="button" name="button" class="btn role-picker-button role-picker-button--student js-role-picker-remover"><span>Ученик</span></button>
                                <button type="button" name="button" class="btn role-picker-button role-picker-button--teacher js-role-picker-remover"><span>Учитель</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row login-form text-center" style="display: none;">
                <div class="btns on-desktop">
                    <a href="#" class="btn-blue"><span></span><b>Авторизоваться</b></a>
                </div>
                <form class="form-horizontal" role="form" method="POST" action="<?php echo e(url('/login')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <div class="col l4 m6 s12 text-center <?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                        <label>
                            <span class="label">E-mail</span>
                            <input type="email" class="field" id="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus>
                        </label>
                        <?php if($errors->has('email')): ?>
                            <span class="help-block d-block">
                                <strong><?php echo e($errors->first('email')); ?></strong>
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col l4 m6 text-center s12">
                        <div class="pos-rel">
                            <label>
                                <span class="label">Пароль</span>
                                <input type="password" id="password" name="password" class="field" value="Пароль" required>
                            </label>
                            <span class="icon-pass js-pass-toggle"></span>
                            <?php if($errors->has('password')): ?>
                                <span class="help-block d-block">
                        <strong><?php echo e($errors->first('password')); ?></strong>
                    </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col s12 text-center">
                        <button type="submit" name="button" class="btn">
                            <span>Войти</span>
                        </button>
                        <a class="btn" href="<?php echo e(url('/register')); ?>">
                            <span>Зарегистрироваться</span>
                        </a>
                        <a class="btn" href="<?php echo e(url('/password/reset')); ?>">
                            <span>Забыл пароль</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


