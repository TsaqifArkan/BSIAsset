<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-BrgCetak">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col" class="col-no">No.</th>
                <th scope="col" class="col-tglInput">Tanggal Input</th>
                <th scope="col">Nama Barang</th>
                <th scope="col" class="col-kodeBrg">Kode Barang</th>
                <th scope="col" class="col-stok">Stok</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($brgcetaks as $i => $brgcetak) : ?>
                <tr>
                    <td class="text-center"><?= $i + 1; ?></td>
                    <td class="text-center"><?= esc($brgcetak['datefmtrbrgcetak']); ?></td>
                    <td><?= esc($brgcetak['nama']); ?></td>
                    <td class="text-center"><?= esc($brgcetak['kode']); ?></td>
                    <td class="text-center"><?= esc($brgcetak['stok']); ?></td>
                    <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" onclick="ubah('<?= $brgcetak['id']; ?>')">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $brgcetak['id']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable-BrgCetak').DataTable({
            "pageLength": 25
        });
    });

    // Konfigurasi Tombol Edit
    function ubah(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('brgcetak/formedit'); ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.viewModalBrgCetak').html(response.data).show();
                    $('#modalEditBrgCtk').modal('show');
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