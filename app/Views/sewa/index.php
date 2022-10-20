<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- FLASH DATA -->
    <div class="flash-data" data-flashdata="<?= session()->getFlashdata('pesan'); ?>"></div>

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Sewa Barang</h1>
        </div>
    </div>

    <?php // dd($getSearch);
    ?>

    <div class="row">
        <div class="col">
            <div class="alert alert-secondary">
                <strong>Perhatian!</strong> untuk mengupload foto barang sewa / perjanjian sewa, tambah sebuah data barang sewa terlebih dahulu, lalu klik ikon <button type="button" class="btn btn-sm btn-secondary" disabled><i class="fa-solid fa-file-arrow-up"></i></button> pada kolom <b>Aksi</b>. <br>
                <button type="button" class="btn btn-sm btn-facebook" disabled><i class="fa-solid fa-file-arrow-up"></i></button> : <strong>Foto Barang Sewa</strong> dan <strong>File Perjanjian Sewa</strong> telah ditambahkan. <br>
                <button type="button" class="btn btn-sm btn-success" disabled><i class="fa-solid fa-file-arrow-up"></i></button> : <strong>Foto Barang Sewa</strong> telah diubah. <br>
                <button type="button" class="btn btn-sm btn-google" disabled><i class="fa-solid fa-file-arrow-up"></i></button> : <strong>File Perjanjian Sewa</strong> telah diupload. <br>
                <button type="button" class="btn btn-sm btn-secondary" disabled><i class="fa-solid fa-file-arrow-up"></i></button> : Tidak ada <strong>Foto Barang Sewa</strong> maupun <strong>File Perjanjian Sewa</strong> yang diupload.</button>
            </div>
        </div>
    </div>

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
            data: {
                dGetId: '<?= $get['id']; ?>',
                dGetHg: '<?= $get['hghlt']; ?>'
            },
            dataType: "JSON",
            success: function(response) {
                $('.sectionsewadata').html(response.data);
                // document.querySelector("#dataTable-Sewa_filter > label > input").value = "<?php // $getSearch ? $getSearch : ''; 
                                                                                                ?>";
            },
            error: function(xhr, ajaxOptions, thrownError) {
                // alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                var tab = window.open('about:blank', '_blank');
                tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Modal Tambah Sewa di index.php (sewa)
    $(document).ready(function() {
        tableSewa();
        $('.tombolTambahSewa').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('sewa/formtambah'); ?>",
                dataType: "JSON",
                success: function(response) {
                    $('.viewModalSewa').html(response.data).show();
                    $('#modalTambahSewa').modal('show');
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