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
            <?php foreach ($cetaks as $i => $cetak) :
            ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= $cetak['datefmtrcetak']; ?></td>
                    <td><?= $cetak['nama']; ?></td>
                    <td><?= $cetak['code']; ?></td>
                    <td><?= $cetak['numfmtr']; ?></td>
                    <td><?= $cetak['keluar']; ?></td>
                    <td><?= $cetak['masuk']; ?></td>
                    <td><?= $cetak['keterangan']; ?></td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="hapus('<?= $cetak['id']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach;
            ?>
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
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        })
    }
</script>