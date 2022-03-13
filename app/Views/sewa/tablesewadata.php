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
</script>