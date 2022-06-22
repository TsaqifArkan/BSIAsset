<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Aset Bank</h1>
        </div>
    </div>

    <?php // dd($assets);
    ?>

    <div class="row">
        <div class="col">
            <div class="alert alert-secondary">
                <strong>Perhatian!</strong> untuk mengupload foto aset, tambah sebuah data aset terlebih dahulu, lalu klik ikon <i class="fa-solid fa-fw fa-image"></i> pada kolom <b>Aksi</b> pada data terkait. <br>
                Warna <strong>hijau</strong> menunjukkan foto aset telah diubah. <br>
            </div>
        </div>
    </div>


    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahAset" data-toggle="modal" data-target="#formModalAset">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Aset Data
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Aset Barang</h6>
                </div>
                <div class="card-body">
                    <div class="sectionasetdata">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModalAset" style="display: none;"></div>

<script>
    function tableAset() {
        $.ajax({
            url: "<?= base_url('aset/getData'); ?>",
            dataType: "JSON",
            success: function(response) {
                $('.sectionasetdata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }

    // Konfigurasi Modal Tambah Aset di index.php (aset)
    $(document).ready(function() {
        tableAset();
        $('.tombolTambahAset').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('aset/formtambah'); ?>",
                dataType: "JSON",
                success: function(response) {
                    $('.viewModalAset').html(response.data).show();
                    $('#modalTambahAset').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>

<?= $this->endSection(); ?>