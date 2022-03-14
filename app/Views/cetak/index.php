<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- BreadCrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Cetak</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Barang Cetakan</h1>
        </div>
    </div>

    <?php d($datas);
    ?>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahCetak" data-toggle="modal" data-target="#formModalCetak">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Barang Cetak
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Cetakan</h6>
                </div>
                <div class="card-body">
                    <div class="sectioncetakdata">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable-Cetak">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">No.</th>
                                        <th scope="col">Tanggal</th>
                                        <th scope="col">Nama Barang</th>
                                        <th scope="col">Kode Barang</th>
                                        <th scope="col">Harga Satuan</th>
                                        <th scope="col">Keluar</th>
                                        <th scope="col">Masuk</th>
                                        <th scope="col">Keterangan</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($datas as $i => $data) :
                                    ?>
                                        <tr>
                                            <td><?= $i + 1; ?></td>
                                            <td><?= $data['tanggal']; ?></td>
                                            <td><?= $data['nama']; ?></td>
                                            <td><?= $data['code']; ?></td>
                                            <td><?= $data['harga']; ?></td>
                                            <td><?= $data['keluar']; ?></td>
                                            <td><?= $data['masuk']; ?></td>
                                            <td><?= $data['keterangan']; ?></td>
                                            <td>
                                                <button type="button" class="btn btn-danger" onclick="alert('belum bisa menghapus data T_T')">Hapus</button>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>