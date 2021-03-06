<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daftar Kategori Barang</h1>
    <?php // dd($categories);
    ?>

    <div class="row mb-4">
        <div class="col-lg-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahKategori" data-toggle="modal" data-target="#formModal">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                Tambah Kategori
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
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" style="width: 10px;">No.</th>
                                    <th scope="col">Nama Kategori</th>
                                    <th scope="col" style="width: 100px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($categories as $category) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $category['nama']; ?></td>
                                        <td class="d-flex justify-content-center">
                                            <a href="<?= base_url('kategori/' . $category['id']); ?>" class="btn btn-info mx-1">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Edit</span>
                                            </a>
                                            <!-- konfigurasi tombol delete -->
                                            <a href="<?= base_url(); ?>/kategori/<?= $category['id']; ?>" class="btn btn-danger mx-1 tombol-hapus">
                                                <i class="fa-solid fa-trash"></i><span> Hapus</span></a>
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

    <!-- Percobaan implementasi GRID -->
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori Barang</h6>
                </div>
                <div class="card-body">
                    <div class="tes-container">
                        <div class="tes-item">1</div>
                        <div class="tes-item">2</div>
                        <div class="tes-item">3</div>
                        <div class="tes-item">4</div>
                        <div class="tes-item">5</div>
                        <div class="tes-item">6</div>
                        <div class="tes-item">7</div>
                        <div class="tes-item">8</div>
                        <div class="tes-item">9</div>
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
                <h5 class="modal-title font-weight-bold" id="judulModal">Tambah Kategori Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form action="<?= base_url(); ?>/kategori/tambah" method="POST" autocomplete="off">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="nama">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama" name="nama">
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