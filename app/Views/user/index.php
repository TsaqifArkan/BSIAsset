<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<!-- FLASH DATA -->
<div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col">
            <div class="jumbotron py-5">
                <h1 class="display-5 text-center">Assalamu'alaikum. Good <?= $greet; ?>, <?= esc($userdata['username']); ?> !</h1>
                <hr class="my-4">
                <div class="row justify-content-center">
                    <div class="card mb-3 shadow" style="width: 50%;">
                        <div class="row no-gutters">
                            <div class="col">
                                <div class="usr-card">
                                    <div class="usr-display-picture"><img src="<?= base_url('img/' . esc($userdata['user_image'])); ?>" alt="" class="img-thumbnail"></div>
                                    <div class="usr-banner"><img src="<?= base_url('img/usr-banner.jpg'); ?>" alt=""></div>
                                    <div class="usr-content">
                                        <div class="row" style="font-size: large;">
                                            <div class="col-5 text-center">
                                                Username
                                            </div>
                                            <div class="col-7 font-weight-bold text-center">
                                                <?= esc($userdata['username']); ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" style="font-size: large;">
                                            <div class="col-5 text-center">
                                                Fullname
                                            </div>
                                            <div class="col-7 font-weight-bold text-center">
                                                <?= esc($userdata['full_name']) ? esc($userdata['full_name']) : '-'; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row" style="font-size: large;">
                                            <div class="col-5 text-center">
                                                Email Address
                                            </div>
                                            <div class="col-7 font-weight-bold text-center">
                                                <?= esc($userdata['email']) ? esc($userdata['email']) : '-'; ?>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col text-center">
                                                <a href="https://www.bankbsi.co.id/" class="btn btn-success" role="button" target="_blank">BSI Official Website</a>
                                                <a href="<?= base_url('user/editprofile/'); ?>" class="btn btn-warning">Edit Profile</a>
                                                <a href="<?= base_url('user/password/'); ?>" class="btn btn-secondary">Ubah Password</a>
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
    </div>
</div>

<?= $this->endSection(); ?>