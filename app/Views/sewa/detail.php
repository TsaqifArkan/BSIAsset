<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="card mb-3 border-bottom-primary shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail Barang Sewa</h6>
                </div>
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <img src="/img/<?= esc($sewa['gambar_sewa']); ?>" alt="" class="img-fluid img-thumbnail d-block m-auto rounded img-preview" style="height:auto; width:500px;">
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Nama Barang
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= esc($sewa['nama']); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Tanggal Sewa
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= esc($tglSewa); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Periode Sewa
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= esc($sewa['periode_sewa']); ?> (bulan)
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Harga Sewa
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= esc($harga); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Sisa Waktu Sewa
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= esc($timeLeft); ?> (hari)
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col font-weight-bold text-center">
                                Tanggal Jatuh Tempo
                            </div>
                            <div class="col-1 font-weight-bold text-center">
                                :
                            </div>
                            <div class="col m-auto">
                                <?= esc($tglSewaJthTempo); ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col text-center">
                                <a href="<?= base_url('sewa'); ?>" class="btn btn-dark font-weight-bold">
                                    <i class="fa-solid fa-fw fa-arrow-left"></i> Kembali ke Daftar Sewa</a>
                            </div>
                            <div class="col text-center">
                                <a href="<?= base_url('pdf/' . $sewa['file_sewa']); ?>" type="button" target="_blank" class="btn btn-primary <?= ($sewa['file_sewa']) ? '' : 'disabled'; ?>" target="_blank">
                                    <i class="fa-solid fa-fw fa-file-arrow-down mr-2"></i>Pratinjau Perjanjian Sewa
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>