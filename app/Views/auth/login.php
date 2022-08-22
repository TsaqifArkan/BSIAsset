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
                                    <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-xs-12 mb-2">
                                        <marquee style="font-size: small;">
                                            Selamat datang di BSI Asset! Silahkan masukkan username dan password Anda!
                                        </marquee>
                                    </div>
                                </div>

                                <?php if (session('errors.login')) : ?>
                                    <div class="alert alert-danger" style="font-size: small;">
                                        <?= session('errors.login') ?>
                                    </div>
                                <?php endif; ?>

                                <form action="<?= base_url('auth/attemptlogin'); ?>" method="post" class="user">
                                    <?= csrf_field(); ?>

                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif; ?>" name="username" placeholder="Username" autofocus>
                                        <div class="invalid-feedback">
                                            <?= session('errors.username'); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif; ?>" placeholder="Password">
                                        <div class="invalid-feedback">
                                            <?= session('errors.password'); ?>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>

                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>