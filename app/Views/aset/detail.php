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
                                <?= $aset['nama']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-2 font-weight-bold">
                                Tanggal Perolehan
                            </div>
                            <div class="col pl-4 m-auto">
                                <?= $aset['tgl_perolehan']; ?>
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
                                <?= $aset['usia_teknis']; ?> (bulan)
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
                                <?= $aset['maks_u_teknis']; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<?= $this->endSection(); ?>