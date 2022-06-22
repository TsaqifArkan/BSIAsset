<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php //echo dd($validation); 
?>

<div class="container" style="max-width: 512px;">
    <div class="row">
        <div class="col">
            <div class="card mb-3 border-bottom-primary shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Profile</h6>
                </div>
                <div class="card-body">

                    <form action="/user/edit" method="POST" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <!-- menyimpan nama file user_image lama -->
                        <input type="hidden" name="oldUserImage" value="<?= esc($profilePict); ?>">

                        <div class="form-group">
                            <div class="row mb-3">
                                <div class="col">
                                    <img src="/img/<?= esc($profilePict); ?>" alt="" class="img-thumbnail d-block m-auto rounded-circle img-preview" style="height:200px; width:200px;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="uploadPict">Profil Picture</label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input <?= ($validation->hasError('profilePict')) ? 'is-invalid' : ''; ?>" id="uploadPict" name="profilePict" onchange="previewImg()">
                                        <label class="custom-file-label" for="uploadPict">Choose a file..</label>
                                        <div class="invalid-feedback">
                                            <?= $validation->getError('profilePict'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= (old('username')) ? (old('username')) : esc($username); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('username'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fullname">Fullname</label>
                            <input type="text" class="form-control" id="fullname" name="fullname" value="<?= (old('fullname')) ? (old('fullname')) : esc($fullname); ?>" placeholder="(opsional)">
                        </div>
                        <div class="form-group mb-4">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control <?= ($validation->hasError('email')) ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?= (old('email')) ? (old('email')) : esc($email); ?>">
                            <div class="invalid-feedback">
                                <?= $validation->getError('email'); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group text-center">
                            <a href="<?= base_url('user'); ?>" class="btn btn-secondary">Back</a>
                            <button type="submit" class="btn btn-primary btnSimpan">Update Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>