<div class="table-responsive">
    <table class="table table-bordered table-hover" id="dataTable-Sewa">
        <thead class="thead-dark">
            <tr class="text-center">
                <th scope="col" class="col-no">No.</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Tanggal Sewa</th>
                <th scope="col">Periode Sewa</th>
                <th scope="col">Harga Sewa</th>
                <th scope="col">Sisa Waktu</th>
                <th scope="col">Jatuh Tempo</th>
                <th scope="col" class="col-aksi">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rents['majority'] as $i => $rent) : ?>
                <tr class="<?= $rents['highlight'][$i]; ?>">
                    <td scope="row" class="text-center"><?= $i + 1; ?></td>
                    <td><?= esc($rent['nama']); ?></td>
                    <td class="text-center"><?= esc($rents['dateFmtrSewa'][$i]); ?></td>
                    <td class="text-center"><?= esc($rent['periode_sewa']); ?> bulan</td>
                    <td class="text-right"><?= esc($rents['numFmtr'][$i]); ?></td>
                    <td class="text-center"><?= esc($rents['timeLeft'][$i]); ?> hari</td>
                    <td class="text-center"><?= esc($rents['dateFmtrTempo'][$i]); ?></td>
                    <td class="text-center">
                        <a href="<?= base_url('sewa/upload/' . $rent['id']); ?>" class="btn <?php if ($rent['gambar_sewa'] != 'default_img.jpg' && $rent['file_sewa'] != null) : ?>
                            <?= 'btn-facebook'; ?>
                        <?php elseif ($rent['gambar_sewa'] != 'default_img.jpg') : ?>
                            <?= 'btn-success'; ?>
                        <?php elseif ($rent['file_sewa'] != null) : ?>
                            <?= 'btn-google'; ?>
                        <?php else : ?>
                            <?= 'btn-secondary'; ?>
                        <?php endif; ?> btn-sm"><i class="fa-solid fa-file-arrow-up"></i></a>
                        <a href="<?= base_url('sewa/detail/' . $rent['id']); ?>" class="btn btn-info btn-sm">Detail</a>
                        <button type="button" class="btn btn-warning btn-sm" onclick="ubah('<?= $rent['id']; ?>')">Edit</button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="hapus('<?= $rent['id']; ?>')">Hapus</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#dataTable-Sewa').DataTable({
            "pageLength": 25
        });
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