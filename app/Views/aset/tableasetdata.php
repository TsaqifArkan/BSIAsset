<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-Aset">
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
                        <a href="<?= base_url('aset/detail/' . $aset['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                        <button type="button" class="btn btn-warning btn-sm" onclick="ubah('<?= $aset['id']; ?>')">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $aset['id']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable-Aset').DataTable();
    });

    // Konfigurasi Tombol Edit
    function ubah(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('aset/formedit'); ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.viewModalAset').html(response.data).show();
                    $('#modalEditAset').modal('show');
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
                    url: "<?= base_url('aset/delete'); ?>",
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
                            tableAset();
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