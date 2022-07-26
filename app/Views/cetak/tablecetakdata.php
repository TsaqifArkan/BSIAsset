<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-Cetak">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="col-no">No.</th>
                <th scope="col" class="col-tglMutasi">Tanggal Mutasi</th>
                <th scope="col">Nama Barang</th>
                <th scope="col" class="col-kodeBrg">Kode Barang</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Harga Satuan</th>
                <th scope="col" class="col-dk">D/K</th>
                <th scope="col">Nominal</th>
                <th scope="col">Saldo</th>
                <th scope="col">Keterangan</th>
                <!-- <th scope="col">Aksi</th> -->
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cetaks as $i => $cetak) : ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= esc($cetak['datefmtrcetak']); ?></td>
                    <td><?= esc($cetak['nama']); ?></td>
                    <td><?= esc($cetak['code']); ?></td>
                    <td class="td-stok"><?= esc($cetak['jumlah']); ?></td>
                    <td><?= esc($cetak['numfmtr']); ?></td>
                    <td class="td-dk"><?= esc($cetak['d_k']); ?></td>
                    <td><?= esc($cetak['nominal']); ?></td>
                    <td><?= esc($cetak['saldo']); ?></td>
                    <td><?= esc($cetak['keterangan']); ?></td>
                    <!-- <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?php // echo $cetak['id']; 
                                                                                            ?>')">Hapus</button>
                    </td> -->
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable-Cetak').DataTable();
    });

    // Konfigurasi Tombol Hapus
    function hapus(id) {
        Swal.fire({
            title: 'Are you sure ?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('cetak/delete'); ?>",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.flashData) {
                            Swal.fire({
                                icon: 'success',
                                title: 'SUCCESS !',
                                text: response.flashData
                            })
                            // simulates similar behavior as an HTTP redirect
                            // window.location.replace("http://localhost:8080/aset");
                            tableCetak();
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                        var tab = window.open('about:blank', '_blank');
                        tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                        tab.document.close(); // to finish loading the page
                    }
                });
            }
        })
    }
</script>