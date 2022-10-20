<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <?php //dd($brgcetakdata); 
    ?>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Transaksi Barang Cetakan</h1>
        </div>
    </div>

    <?php // d($cetaks);
    ?>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahCetak" data-toggle="modal" data-target="#formModalCetak">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Data Transaksi
            </button>
        </div>
        <div class="col text-right">
            <a href="cetak/print" type="button" class="btn btn-primary" target="_blank">
                <i class="fa-solid fa-fw fa-print mr-2"></i>Print</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Transaksi Barang Cetakan</h6>
                </div>
                <div class="card-body">
                    <div class="sectioncetakdata">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModalCetak" style="display: none;"></div>

<script>
    function tableCetak() {
        $.ajax({
            url: "<?= base_url('cetak/getData'); ?>",
            dataType: "JSON",
            success: function(response) {
                $('.sectioncetakdata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Modal Tambah Barang Cetak di index.php (cetak)
    $(document).ready(function() {
        tableCetak();
        $('.tombolTambahCetak').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('cetak/formtambah'); ?>",
                dataType: "JSON",
                success: function(response) {
                    $('.viewModalCetak').html(response.data).show();
                    $('#modalTambahCetak').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    var tab = window.open('about:blank', '_blank');
                    tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                    tab.document.close(); // to finish loading the page
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>