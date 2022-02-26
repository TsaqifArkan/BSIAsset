<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daftar Aset Bank</h1>
    <?php // dd($assets);
    ?>

    <div class="row mb-4">
        <div class="col-lg-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahKategori" data-toggle="modal" data-target="#formModal">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                Tambah Aset Data
            </button>
        </div>
    </div>

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>
    <?php if (session()->getFlashdata()) : ?>
        <!-- <div class="row">
            <div class="col-lg-8">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong><?= session()->getFlashdata('alert'); ?></strong><?= session()->getFlashdata('msg'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div> -->
    <?php endif; ?>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Aset Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Tanggal Perolehan</th>
                                    <th scope="col">Harga Perolehan</th>
                                    <th scope="col">Usia Teknis</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($assets as $aset) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $aset['nama']; ?></td>
                                        <td><?= $aset['tgl_perolehan']; ?></td>
                                        <td><?= $aset['harga']; ?></td>
                                        <td><?= $aset['usia_teknis']; ?></td>
                                        <td class="d-flex justify-content-center">
                                            <a href="<?= base_url('aset/' . $aset['id']); ?>" class="btn btn-info mx-1">
                                                <span>Detail</span>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="judulModal">Tambah Aset Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url(); ?>/aset/tambah" method="POST" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" class="form-control" id="nama" name="nama">
                    </div>
                    <div class="form-group">
                        <label for="tglPerolehan">Tanggal Perolehan</label>
                        <input type="date" class="form-control" id="tglPerolehan" name="tglPerolehan">
                    </div>
                    <div class="form-group">
                        <label for="hargaPerolehan">Harga Perolehan</label>
                        <input type="number" class="form-control" id="hargaPerolehan" name="hargaPerolehan">
                    </div>
                    <div class="form-group">
                        <label for="usiaTeknis">Usia Teknis</label>
                        <input type="number" class="form-control" id="usiaTeknis" name="usiaTeknis">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah Data</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>