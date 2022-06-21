<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <?php // dd($userdata) 
    ?>

    <div class="jumbotron">
        <h1 class="display-5">Assalamu'alaikum. Good <?= $greet; ?>, <?= esc($userdata->username); ?> !</h1>
        <p class="lead"><em>“Life is like riding a bicycle. To keep your balance, you must keep moving.”</em> - Albert Einstein</p>
        <hr class="my-4">
        <p>Bank Syariah Indonesia adalah bank di Indonesia yang bergerak di bidang perbankan syariah. Bank ini diresmikan pada tanggal 1 Februari 2021 pukul 13.00 WIB atau bertepatan dengan tanggal 19 Jumadil Akhir 1442 H. Bank ini merupakan hasil penggabungan Bank Syariah Mandiri, BNI Syariah, dan BRI Syariah menjadi Satu.
            <a class="btn btn-sm btn-light" href="https://id.wikipedia.org/wiki/Bank_Syariah_Indonesia" role="button" target="_blank">Selengkapnya</a>
        </p>
        <a class="btn btn-success btn-lg" href="https://www.bankbsi.co.id/" role="button" target="_blank">Our Website</a>
    </div>

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3 shadow" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('img/' . esc($userdata->user_image)); ?>" alt="<?= esc($userdata->username); ?>" class="img-thumbnail rounded-circle" style="height: auto; width: 100%;">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h3><?= esc($userdata->username); ?></h3>
                                </li>
                                <?php if ($userdata->fullname) : ?>
                                    <li class="list-group-item">
                                        <h5><?= esc($userdata->fullname); ?></h5>
                                    </li>
                                <?php endif; ?>
                                <li class="list-group-item"><?= esc($userdata->email); ?></li>
                                <li class="list-group-item">
                                    <a href="<?= base_url('user/formedit/'); ?>" class="btn btn-warning">Edit</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>