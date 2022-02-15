<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daftar Kategori Barang</h1>
    <?php // dd($categories);
    ?>

    <div class="row mb-4">
        <div class="col-lg-8">
            <a href="" class="btn btn-facebook">Tambah Kategori</a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Kategori Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col" class="col-1">No.</th>
                                    <th scope="col" class="col-5">Nama Kategori</th>
                                    <th scope="col" class="col-2">Aksi</th>
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
                                            <a href="<?= base_url('kategori/' . $category['id']); ?>" class="btn btn-danger mx-1">
                                                <i class="fa-solid fa-trash"></i>
                                                <span>Hapus</span>
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

<?= $this->endSection(); ?>