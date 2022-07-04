<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container" style="max-width: 512px;">
    <div class="row">
        <div class="col">
            <div class="card mb-3 border-bottom-primary shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Ubah Password</h6>
                </div>
                <div class="card-body">

                    <form action="/user/changePassword" method="POST">
                        <?= csrf_field(); ?>
                        <div class="form-group">
                            <label for="oldPassword">Password Lama</label>
                            <input type="password" class="form-control <?= ($validation->hasError('oldPassword')) ? 'is-invalid' : ''; ?>" id="oldPassword" name="oldPassword">
                            <div class="invalid-feedback">
                                <?= $validation->getError('oldPassword'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="newPassword">Password Baru</label>
                            <input type="password" class="form-control <?= ($validation->hasError('newPassword')) ? 'is-invalid' : ''; ?>" id="newPassword" name="newPassword">
                            <div class="invalid-feedback">
                                <?= $validation->getError('newPassword'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="konfNewPassword">Konfirmasi Password Baru</label>
                            <input type="password" class="form-control <?= ($validation->hasError('konfNewPassword')) ? 'is-invalid' : ''; ?>" id="konfNewPassword" name="konfNewPassword">
                            <div class="invalid-feedback">
                                <?= $validation->getError('konfNewPassword'); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group text-center">
                            <a href="<?= base_url('user'); ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary btnSimpan">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>