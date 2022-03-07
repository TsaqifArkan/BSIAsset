<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- BreadCrumb -->
    <div class="row">
        <div class="col-lg-8">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('aset'); ?>">Aset</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg">
            <h1 class="h3 mb-4 text-gray-800">Detail Aset</h1>
            <?php // d($aset);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Aset</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Nama Barang
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $aset->nama; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Tanggal Perolehan
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $aset->tgl_perolehan; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Harga Perolehan
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $harga; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Usia Teknis
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $aset->usia_teknis; ?> (bulan)
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Nilai Buku
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $nilaiBuku; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Sisa Usia Teknis
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $sisaUTeknis; ?> (bulan)
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Batas Akhir Usia Teknis
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $aset->maks_u_teknis; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


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
                                    <?= $aset->maks_u_teknis; ?>
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