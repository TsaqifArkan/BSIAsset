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
        <div class="col-lg-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1; ?>
                    <?php foreach ($categories as $category) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td><?= $category['nama']; ?></td>
                            <td>
                                <a href="<?= base_url('kategori/' . $category['id']); ?>" class="btn btn-info">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                    <span>Edit</span>
                                </a>
                                <a href="<?= base_url('kategori/' . $category['id']); ?>" class="btn btn-danger">
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

<?= $this->endSection(); ?>