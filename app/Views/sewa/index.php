<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- BreadCrumb -->
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Sewa</li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Sewa Barang</h1>
        </div>
    </div>

    <?php // dd($rents);
    ?>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahSewa" data-toggle="modal" data-target="#formModalSewa">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Sewa
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Sewa Barang</h6>
                </div>
                <div class="card-body">
                    <div class="sectionsewadata">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModalSewa" style="display: none;"></div>

<script>
    function tableSewa() {
        $.ajax({
            url: "<?= base_url('sewa/getData'); ?>",
            dataType: "JSON",
            success: function(response) {
                $('.sectionsewadata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    // Konfigurasi Modal Tambah Sewa di index.php (sewa)
    $(document).ready(function() {
        tableSewa();
    });
</script>
<?= $this->endSection(); ?>