<?= $this->extend('templates/index'); ?>
<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Transaksi Barang Cetak</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="alert alert-secondary">
                <strong>Perhatian!</strong> Ini adalah halaman untuk menampilkan daftar <b>Transaksi Barang Cetak</b>. Pilih <strong>Barang Cetak</strong> terlebih dahulu untuk dapat menampilkan <strong>Daftar Transaksi</strong>-nya.
            </div>
        </div>
    </div>

    <div class="container" style="max-width: 512px;">
        <div class="row">
            <div class="col">
                <div class="card mb-3 border-bottom-primary shadow">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pilih Barang Cetak</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nama">Nama Barang</label>
                            <select class="form-control" id="nama" name="nama">
                                <option value="" disabled selected>--Pilih Barang--</option>
                                <?php foreach ($hasil as $hsl) : ?>
                                    <option value="<?= esc($hsl['id']); ?>"><?= esc($hsl['nama']); ?> - <?= esc($hsl['kode']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sectiontransaksidata"></div>
</div>

<script>
    function tableTransaksi(id) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('transaksi/getData'); ?>",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(response) {
                $('.sectiontransaksidata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    $(document).ready(function() {
        $('#nama').on('change', function() {
            // console.log(this.value);
            tableTransaksi(this.value);
        });
    });
</script>

<?= $this->endSection(); ?>