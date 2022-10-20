<?php //dd($transactions);
?>
<div class="row">
    <div class="col">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Tabel Transaksi Barang Cetakan</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">

                    <div class="row mb-2 mr-1">
                        <div class="col pr-0">
                            <h4 class="text-dark"><strong><?= $namaKode['nama']; ?></strong> - <?= $namaKode['kode']; ?></h4>
                        </div>
                    </div>

                    <div class="row mb-3 mr-1">
                        <div class="col">
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-facebook tombolTambahTrans" data-toggle="modal" data-target="#formModalTrans">
                                <!-- value data-bs-target harus sama dg nama modalnya -->
                                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Data Transaksi
                            </button>
                        </div>
                        <div class="col text-right">
                            <a href="transaksi/print/<?= $idBrgCtk ?>" type="button" class="btn btn-primary" target="_blank">
                                <i class="fa-solid fa-fw fa-print mr-2"></i>Print</a>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover" id="dataTable-Transaksi">
                        <thead class="thead-dark">
                            <tr class="text-center">
                                <th scope="col" class="col-no">No.</th>
                                <th scope="col" class="col-tglMutasi">Tanggal Mutasi</th>
                                <!-- <th scope="col">Nama Barang</th> -->
                                <!-- <th scope="col" class="col-kodeBrg">Kode Barang</th> -->
                                <th scope="col" class="col-stok">Jumlah</th>
                                <th scope="col" class="col-hrgPrlh">Harga Satuan</th>
                                <th scope="col" class="col-dk">D/K</th>
                                <th scope="col" class="col-hrgPrlh">Nominal</th>
                                <th scope="col" class="col-hrgPrlh">Saldo</th>
                                <th scope="col">Keterangan</th>
                                <!-- <th scope="col">Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $i => $trans) : ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1; ?></td>
                                    <td class="text-center"><?= esc($trans['datefmtrcetak']); ?></td>
                                    <td class="text-center"><?= esc($trans['jumlah']); ?></td>
                                    <td class="text-right"><?= esc($trans['numfmtr']); ?></td>
                                    <td class="text-center"><?= esc($trans['d_k']); ?></td>
                                    <td class="text-right"><?= esc($trans['nominal']); ?></td>
                                    <td class="text-right"><?= esc($trans['saldo']); ?></td>
                                    <td><?= esc($trans['keterangan']); ?></td>
                                    <!-- <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?php // echo $cetak['id']; 
                                                                                            ?>')">Hapus</button>
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
<div class="viewModalTrans" style="display: none;"></div>
<script>
    $(document).ready(function() {
        $('#dataTable-Transaksi').DataTable({
            "pageLength": 25
        });
        // Konfigurasi Modal Tambah Data Transaksi di tabletransaksi.php (transaksi)
        $('.tombolTambahTrans').click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "<?= base_url('transaksi/formtambah'); ?>",
                data: {
                    id: <?= $idBrgCtk; ?>
                },
                dataType: "JSON",
                success: function(response) {
                    $('.viewModalTrans').html(response.data).show();
                    $('#modalTambahTrans').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    var tab = window.open('about:blank', '_blank');
                    tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                    tab.document.close(); // to finish loading the page
                }
            });
        });
    });
</script>