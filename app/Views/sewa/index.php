<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Daftar Sewa Barang</h1>
    <?php // dd($rents);
    ?>

    <div class="row mb-4">
        <div class="col-lg-8">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahKategori" data-toggle="modal" data-target="#formModal">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                Tambah Sewa Barang
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Sewa Barang</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Tanggal Sewa</th>
                                    <th scope="col">Harga Sewa</th>
                                    <th scope="col">Jatuh Tempo</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($rents as $rent) : ?>
                                    <tr>
                                        <th scope="row"><?= $i++; ?></th>
                                        <td><?= $rent['nama']; ?></td>
                                        <td><?= $rent['tgl_sewa']; ?></td>
                                        <td><?= numfmt_format($numFmt, $rent['harga']); ?></td>
                                        <td><?= $rent['jatuh_tempo']; ?></td>
                                        <!-- <td class="d-flex justify-content-center">
                                            <a href="<?php // echo base_url('aset/' . $aset['id']); 
                                                        ?>" class="btn btn-info mx-1">
                                                <span>Detail</span>
                                            </a>
                                        </td> -->
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