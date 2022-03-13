<div class="table-responsive">
    <table class="table table-bordered table-hover dataTableDisplay" id="dataTable-Sewa">
        <thead class="thead-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Barang</th>
                <th scope="col">Tanggal Sewa</th>
                <th scope="col">Periode Sewa</th>
                <th scope="col">Harga Sewa</th>
                <th scope="col">Sisa Hari</th>
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
                    <td><?= $rent['periode_sewa']; ?></td>
                    <td><?= $rents['numFmtr'][$i]; ?></td>
                    <td> - </td>
                    <td><?= $rents['dateFmtrTempo'][$i]; ?></td>
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
<script>
    // $(document).ready(function() {
    //     $('#dataTable-Sewa').DataTable();
    // });
</script>