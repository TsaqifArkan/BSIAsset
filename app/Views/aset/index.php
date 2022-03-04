<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- BreadCrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Aset</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Aset Bank</h1>
        </div>
    </div>

    <?php // dd($assets);
    ?>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahData" data-toggle="modal" data-target="#formModal">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                Tambah Aset Data
            </button>
        </div>
    </div>

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('msg'); ?>"></div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Aset Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="col-no">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col" class="col-tglPrlh">Tanggal Perolehan</th>
                                    <th scope="col" class="col-hrgPrlh">Harga Perolehan</th>
                                    <th scope="col" class="col-usiaTeknis">Usia Teknis</th>
                                    <th scope="col" class="col-aksi">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;
                                $j = 0; ?>
                                <?php // dd($assets);
                                ?>
                                <?php foreach ($assets['majority'] as $aset) : ?>
                                    <?php
                                    // dd($assets);
                                    // dd($aset);
                                    ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $aset['nama']; ?></td>
                                        <td><?= $assets['dateFmtr'][$j]; ?></td>
                                        <td><?= $assets['numFmtr'][$j]; ?></td>
                                        <td><?= $aset['usia_teknis']; ?> bulan</td>
                                        <td>
                                            <a href="<?= base_url('aset/detail/' . $aset['id']); ?>" class="btn btn-info">
                                                Detail
                                            </a>
                                            <a href="<?= base_url('aset/edit/' . $aset['id']); ?>" class="btn btn-warning tampilModalEdit" data-toggle="modal" data-target="#formModal" data-id="<?= $aset['id']; ?>">
                                                Edit
                                            </a>
                                            <a href="<?= base_url('aset/delete/' . $aset['id']); ?>" class="btn btn-danger tombol-hapus">
                                                Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $j++; ?>
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
<div class="modal fade mt-5" id="formModal" tabindex="-1" aria-labelledby="judulModal" aria-hidden="true">
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
                    <input type="hidden" name="id" id="id">
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
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" class="form-control" id="hargaPerolehan" name="hargaPerolehan">
                            <div class="input-group-append">
                                <span class="input-group-text">,00</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usiaTeknis">Usia Teknis (bulan)</label>
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