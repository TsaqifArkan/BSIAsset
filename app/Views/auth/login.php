<?= $this->extend('auth/templates/index'); ?>

<?= $this->section('content'); ?>

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">
            <!-- jika tdk menggunakan gambar, set class diatas ini menjadi col-md-6, lalu ke div setelah image -->

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block imageLogin"></div>
                        <!-- ubah class berikut ini mjd col-lg -->
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <!-- <h1 class="h4 text-gray-900 mb-4"><?php // echo lang('Auth.loginTitle'); 
                                                                            ?></h1> -->
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>

                                <?= view('Myth\Auth\Views\_message_block'); ?>

                                <form action="<?= route_to('login'); ?>" method="post" class="user">
                                    <?= csrf_field(); ?>

                                    <?php if ($config->validFields === ['email']) : ?>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif; ?>" name="login" placeholder="<?= lang('Auth.email'); ?>" autofocus>
                                            <div class="invalid-feedback">
                                                <?= session('errors.login'); ?>
                                            </div>
                                        </div>
                                    <?php else : ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif; ?>" name="login" placeholder="<?= lang('Auth.emailOrUsername'); ?>" autofocus>
                                            <div class="invalid-feedback">
                                                <?= session('errors.login'); ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif; ?>" placeholder="<?= lang('Auth.password'); ?>">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password'); ?>
                                        </div>
                                    </div>

                                    <?php if ($config->allowRemembering) : ?>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck" name="remember" <?php if (old('remember')) : ?> checked <?php endif; ?>>
                                                <label class="custom-control-label" for="customCheck"><?= lang('Auth.rememberMe'); ?></label>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <!-- <button type="submit" class="btn btn-primary btn-user btn-block">
                                        <?php // echo lang('Auth.loginAction'); 
                                        ?>
                                    </button> -->
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>

                                <hr>

                                <!-- <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div> -->

                                <?php if ($config->activeResetter) : ?>
                                    <div class="text-center">
                                        <a class="small" href="<?= route_to('forgot'); ?>"><?= lang('Auth.forgotYourPassword'); ?></a>
                                    </div>
                                <?php endif; ?>

                                <?php if ($config->allowRegistration) : ?>
                                    <div class="text-center">
                                        <!-- <a class="small" href="<?php // echo route_to('register'); 
                                                                    ?>"><?php // echo lang('Auth.needAnAccount'); 
                                                                        ?></a> -->
                                    </div>
                                <?php endif; ?>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>