<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-BrgCetak">
        <thead class="thead-dark">
            <tr>
                <th scope="col" class="col-no">No.</th>
                <th scope="col">Tanggal Input</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Kode Barang</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brgcetaks as $i => $brgcetak) : ?>
                <tr>
                    <td><?= $i + 1; ?></td>
                    <td><?= esc($brgcetak['datefmtrbrgcetak']); ?></td>
                    <td><?= esc($brgcetak['nama']); ?></td>
                    <td><?= esc($brgcetak['code']); ?></td>
                    <td><?= esc($brgcetak['stok']); ?></td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $brgcetak['id']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable-BrgCetak').DataTable();
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
                    url: "<?= base_url('brgcetak/delete'); ?>",
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
                            tableBrgCetak();
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