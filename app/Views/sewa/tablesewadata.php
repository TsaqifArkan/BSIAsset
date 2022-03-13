<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-Sewa">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Tanggal Sewa</th>
                <th scope="col">Periode Sewa</th>
                <th scope="col">Harga Sewa</th>
                <th scope="col">Sisa Waktu</th>
                <th scope="col">Jatuh Tempo</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rents['majority'] as $i => $rent) : ?>
                <tr>
                    <th scope="row"><?= $i + 1; ?></th>
                    <td><?= $rent['nama']; ?></td>
                    <td><?= $rents['dateFmtrSewa'][$i]; ?></td>
                    <td><?= $rent['periode_sewa']; ?> bulan</td>
                    <td><?= $rents['numFmtr'][$i]; ?></td>
                    <td><?= $rents['timeLeft'][$i]; ?> hari</td>
                    <td><?= $rents['dateFmtrTempo'][$i]; ?></td>
                    <td>
                        <button type="button" class="btn btn-warning" onclick="ubah('<?= $rent['id']; ?>')">Edit</button>
                        <button type="button" class="btn btn-danger" onclick="hapus('<?= $rent['id']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable-Sewa').DataTable();
    });

    // Konfigurasi Tombol Edit
    function ubah(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('sewa/formedit'); ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.viewModalSewa').html(response.data).show();
                    $('#modalEditSewa').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

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
                    url: "<?= base_url('sewa/delete'); ?>",
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
                            tableSewa();
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