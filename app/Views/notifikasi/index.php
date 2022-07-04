<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php // dd($notifikasi);
?>

<div class="container">
    <div class="row">
        <div class="col">
            <div class="alert alert-dark alert-dismissible fade show" role="alert">
                <strong>Perhatian!</strong> Anda dapat menghapus notifikasi secara permanen dengan menghapus data <strong>barang sewa</strong> yang sudah jatuh tempo.
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Notifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($notifikasi as $notif) : ?>
                            <?php // for ($i = 0; $i < 10; $i++) : 
                            ?>
                            <div class="alert alert-<?= esc($notif['tipe']); ?> alert-dismissible fade show" role="alert">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 font-weight-bold text-gray-800"><?= esc($notif['judul']); ?></h5>
                                    <small><?= esc($notif['sub_konten']); ?></small>
                                </div>
                                <p class="mb-1 font-weight-bolder">
                                    <a href="<?= base_url($notif['link']); ?>" class="alert-link"><?= esc($notif['konten']); ?></a>
                                </p>
                                <small><?= esc($notif['info']); ?></small>
                                <button type="button" class="close btnClose" data-dismiss="alert" aria-label="Close" data-id="<?= $notif['id']; ?>">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <?php // endfor; 
                            ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('.btnClose').click(function() {
        let id = $(this).data('id');
        // console.log(id);
        $.ajax({
            url: "<?= base_url('notifikasi/delnotif'); ?>" + '/' + id,
        });
    });
</script>
<?= $this->endSection(); ?>