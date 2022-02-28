<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Detail Aset</h1>
    <?php // d($aset);
    ?>

    <div class="row">
        <div class="col-lg-2">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4>Nama Barang</h4>
                                </li>
                                <li class="list-group-item">
                                    Tanggal Perolehan
                                </li>
                                <li class="list-group-item">
                                    Harga Perolehan
                                </li>
                                <li class="list-group-item">
                                    Usia Teknis
                                </li>
                                <li class="list-group-item">
                                    Nilai Buku
                                </li>
                                <li class="list-group-item">
                                    Sisa Usia Teknis
                                </li>
                                <li class="list-group-item">
                                    Expired Date
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-12">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h4><?= $aset->nama; ?></h4>
                                </li>
                                <li class="list-group-item">
                                    <?= $aset->tgl_perolehan; ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $harga; ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $aset->usia_teknis; ?> (bulan)
                                </li>
                                <li class="list-group-item">
                                    <?= $nilaiBuku; ?>
                                </li>
                                <li class="list-group-item">
                                    <?= $sisaUTeknis; ?> (bulan)
                                </li>
                                <li class="list-group-item">
                                    <?= $aset->exp_date; ?>
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