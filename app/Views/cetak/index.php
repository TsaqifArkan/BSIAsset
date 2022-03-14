<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- BreadCrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Cetak</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Barang Cetakan</h1>
        </div>
    </div>

    <?php // d($cetaks);
    ?>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahCetak" data-toggle="modal" data-target="#formModalCetak">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Barang Cetak
            </button>
        </div>
        <div class="col text-right">
            <a href="cetak/print" type="button" class="btn btn-primary" target="_blank">
                <i class="fa-solid fa-fw fa-print mr-2"></i>Cetak</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Cetakan</h6>
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
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
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
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>