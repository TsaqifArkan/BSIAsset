<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<div class="container-fluid">

    <?php // dd($userdata) 
    ?>

    <div class="jumbotron">
        <h1 class="display-4">Good <?= $greet; ?>, <?= $userdata->username; ?> !</h1>
        <p class="lead"><em>“Life is like riding a bicycle. To keep your balance, you must keep moving.”</em> - Albert Einstein</p>
        <hr class="my-4">
        <p>Bank Syariah Indonesia adalah bank di Indonesia yang bergerak di bidang perbankan syariah. Bank ini diresmikan pada tanggal 1 Februari 2021 pukul 13.00 WIB atau bertepatan dengan tanggal 19 Jumadil Akhir 1442 H. Bank ini merupakan hasil penggabungan Bank Syariah Mandiri, BNI Syariah, dan BRI Syariah menjadi Satu.
            <a class="btn btn-sm btn-light" href="https://id.wikipedia.org/wiki/Bank_Syariah_Indonesia" role="button" target="_blank">Selengkapnya</a>
        </p>
        <a class="btn btn-success btn-lg" href="https://www.bankbsi.co.id/" role="button" target="_blank">Our Website</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3" style="max-width: 540px;">
                <div class="row no-gutters">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('img/' . $userdata->user_image); ?>" width="100%" height="auto" alt="<?= $userdata->username; ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <h3><?= $userdata->username; ?></h3>
                                </li>
                                <?php if ($userdata->fullname) : ?>
                                    <li class="list-group-item">
                                        <h5><?= $userdata->fullname; ?></h5>
                                    </li>
                                <?php endif; ?>
                                <li class="list-group-item"><?= $userdata->email; ?></li>
                                <li class="list-group-item">
                                    <button type="button" class="btn btn-warning" onclick="ubah()">Edit</button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="viewModalUser" style="display: none;"></div>

<script>
    // Konfigurasi Tombol Edit
    function ubah() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('user/formedit'); ?>",
            dataType: "JSON",
            success: function(response) {
                if (response.data) {
                    $('.viewModalUser').html(response.data).show();
                    $('#modalEditUser').modal('show');
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
</script>
<?= $this->endSection(); ?>