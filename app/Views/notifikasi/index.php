<?= $this->extend('templates/index'); ?>

<?= $this->section('page-content'); ?>

<?php // dd($notifikasi);
?>

<div class="container-fluid">
    <div class="row mb-2">
        <div class="col">
            <h1 class="h3 text-gray-800">Daftar Notifikasi</h1>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">List Notifikasi</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <?php foreach ($notifikasi as $notif) : ?>
                            <?php // for ($i = 0; $i < 10; $i++) : 
                            ?>
                            <div class="alert alert-<?= $notif['tipe']; ?> alert-dismissible fade show" role="alert">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1 font-weight-bold text-gray-800"><?= $notif['judul']; ?></h5>
                                    <small><?= $notif['sub_konten']; ?></small>
                                </div>
                                <p class="mb-1 font-weight-bolder"><?= $notif['konten']; ?></p>
                                <small><?= $notif['waktu']; ?></small>
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
        console.log(id);
        $.ajax({
            url: "<?= base_url('notifikasi/delnotif'); ?>" + '/' + id,
        });
    });
</script>
<?= $this->endSection(); ?>