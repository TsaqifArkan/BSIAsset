<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php // dd($jatuhTempo);
?>

<div class="container">
    <div class="list-group">
        <?php foreach ($jatuhTempo as $i => $jt) : ?>
            <?php // for ($i = 0; $i < 10; $i++) : 
            ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">Barang Sewa Jatuh Tempo!!!</h5>
                    <small>3 days ago</small>
                </div>
                <p class="mb-1"><?= $jt['nama']; ?></p>
                <small><?= $jt['jatuh_tempo']; ?></small>
                <button type="button" class="close btnClose" data-dismiss="alert" aria-label="Close" data-id="<?= $i; ?>">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <?php // endfor; 
            ?>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $('.btnClose').click(function() {
        let id = $(this).data('id');
        console.log(id);
        $.ajax({
            url: "<?= base_url('notifikasi/delnotif'); ?>" + '/' + id,
        });
    });
</script>
<?= $this->endSection(); ?>