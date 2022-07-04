<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Barang Cetak</h1>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="alert alert-secondary">
                <strong>Perhatian!</strong> Ini adalah halaman untuk menampilkan daftar <b>Barang Cetak</b>. Barang Cetak yang terdapat di dalam tabel ini akan tersedia dan ditampilkan saat penambahan data <b>Transaksi Barang Cetakan</b>. <br>
                Menghapus data <b>Barang Cetak</b> akan menghapus <b>Transaksi Barang Cetakan</b> terkait secara otomatis.
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-facebook tombolTambahBrgCetak" data-toggle="modal" data-target="#formModalBrgCetak">
                <!-- value data-bs-target harus sama dg nama modalnya -->
                <i class="fa-solid fa-fw fa-circle-plus mr-1"></i>Tambah Barang Cetak
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Tabel Barang Cetak</h6>
                </div>
                <div class="card-body">
                    <div class="sectionbrgcetakdata">

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModalBrgCetak" style="display: none;"></div>

<script>
    function tableBrgCetak() {
        $.ajax({
            url: "<?= base_url('brgcetak/getData'); ?>",
            dataType: "JSON",
            success: function(response) {
                $('.sectionbrgcetakdata').html(response.data);
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                // var tab = window.open('about:blank', '_blank');
                // tab.document.write(xhr.responseText); // where 'html' is a variable containing your HTML
                // tab.document.close(); // to finish loading the page
            }
        });
    }

    // Konfigurasi Modal Tambah Data Barang Cetak di index.php (brgcetak)
    $(document).ready(function() {
        tableBrgCetak();
        $('.tombolTambahBrgCetak').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: "<?= base_url('brgcetak/formtambah'); ?>",
                dataType: "JSON",
                success: function(response) {
                    $('.viewModalBrgCetak').html(response.data).show();
                    $('#modalTambahBrgCetak').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                }
            });
        });
    });
</script>
<?= $this->endSection(); ?>