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
            <button type="button" class="btn btn-facebook tombolTambah" data-toggle="modal" data-target="#formModal">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Aset Data
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
                                <?php foreach ($assets['majority'] as $i => $aset) : ?>
                                    <tr>
                                        <th scope="row"><?= $i + 1; ?></th>
                                        <td><?= $aset['nama']; ?></td>
                                        <td><?= $assets['dateFmtr'][$i]; ?></td>
                                        <td><?= $assets['numFmtr'][$i]; ?></td>
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
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModal" style="display: none;"></div>

<?= $this->endSection(); ?>