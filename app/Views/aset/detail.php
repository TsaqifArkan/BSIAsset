<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- BreadCrumb -->
    <div class="row">
        <div class="col">
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
        <div class="col">
            <h1 class="h3 mb-4 text-gray-800">Detail Aset</h1>
            <?php // d($aset);
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card mb-3 border-bottom-primary">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Aset</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Nama Barang
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $aset['nama']; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Tanggal Perolehan
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $tglPerolehan; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Harga Perolehan
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $harga; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Usia Teknis
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $aset['usia_teknis']; ?> (bulan)
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Nilai Buku
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $nilaiBuku; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Sisa Usia Teknis
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $sisaUTeknis; ?> (bulan)
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Batas Akhir Usia Teknis
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= $maksUTeknis; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col text-center">
                                <a href="<?= base_url('aset'); ?>" class="btn btn-dark font-weight-bold">
                                    <i class="fa-solid fa-fw fa-arrow-left"></i> Kembali ke Daftar Aset</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>


<?= $this->endSection(); ?>