<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?= lang('Auth.register'); ?></h1>
                                </div>

                                <?= view('Myth\Auth\Views\_message_block'); ?>

                                <form action="<?= route_to('register'); ?>" method="post" class="user">
                                    <?= csrf_field(); ?>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif; ?>" id="exampleInputUsername" placeholder="<?= lang('Auth.username'); ?>" name="username" value="<?= old('username'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif; ?>" id="exampleInputEmail" placeholder="<?= lang('Auth.email'); ?>" name="email" value="<?= old('email'); ?>">
                                        <small id="emailHelp" class="form-text text-muted"><?= lang('Auth.weNeverShare'); ?></small>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif; ?>" id="exampleInputPassword" placeholder="<?= lang('Auth.password'); ?>" name="password" autocomplete="off">
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif; ?>" id="exampleRepeatPassword" placeholder="<?= lang('Auth.repeatPassword'); ?>" name="pass_confirm" autocomplete="off">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        <?= lang('Auth.register'); ?>
                                    </button>
                                </form>
                                <hr>
                                <!-- <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div> -->
                                <!-- <div class="text-center">
                                    <p> <? // echo lang('Auth.alreadyRegistered'); 
                                        ?> <a class="small" href="<? // echo route_to('login'); 
                                                                    ?>"><? // echo lang('Auth.signIn'); 
                                                                        ?></a></p>
                                </div> -->
                                <div class="text-center">
                                    <p> <?= lang('Auth.alreadyRegistered');
                                        ?> <a class="small" href="<?= route_to('login');
                                                                    ?>">Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>