<?php // dd($notifikasi); 
?>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">

        <!-- Nav Item - Alerts -->
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-fw fa-bell"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter" id="numberNotif"><?= sizeof($notifikasi); ?></span>
            </a>
            <!-- Dropdown - Alerts -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown" style="min-width: 24rem;">
                <h6 class="dropdown-header">
                    Notifikasi
                </h6>
                <div class="row">
                    <div class="col">
                        <div class="alert alert-dark my-1 mx-1 text-center" role="alert">
                            <strong>Perhatian!</strong> Anda dapat menghapus notifikasi secara permanen dengan menghapus data <strong>barang sewa</strong> yang sudah jatuh tempo.
                        </div>
                    </div>
                </div>
                <div class="row dropdown-menu-ave">
                    <div class="col">
                        <?php foreach ($notifikasi as $i => $notif) : ?>
                            <a class="dropdown-item d-flex align-items-center alert-<?= esc($notif['tipe']); ?>" href="<?= base_url($notif['link']); ?>" style="<?= ($i > 3) ? 'display: none;' : 'display:inline-block;' ?>">
                                <div class="col mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fa-solid fa-fw fa-truck-ramp-box text-white"></i>
                                    </div>
                                </div>
                                <div class="col-9 px-0">
                                    <div class="text-gray-700" style="font-size:small;"><?= esc($notif['info']); ?></div>
                                    <div class="font-weight-bold text-gray-800" style="font-size: small;"><?= esc($notif['judul']); ?></div>
                                    <span style="font-style: italic;"><?= esc($notif['konten']); ?></span>
                                    <div class="small text-gray-600"><?= esc($notif['sub_konten']); ?></div>
                                </div>
                                <div class="col">
                                    <!-- <button type="button" class="close btnClose" data-dismiss="alert" aria-label="Close" data-id="<?php // echo $notif['id']; 
                                                                                                                                        ?>"> -->
                                    <button type="button" class="close btnClose" data-dismiss="alert" aria-label="Close" data-id="<?= $i; ?>">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </a>
                        <?php endforeach; ?>
                        <!-- <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a> -->
                    </div>
                </div>
            </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                    <?= session('sess_user.username'); ?></span>
                <img class="img-profile rounded-circle" src="<?= base_url(); ?>/img/<?= session('sess_user.user_image'); ?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?= base_url('/'); ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    My Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>

</nav>

<script>
    $('.dropdown-menu-ave').on('click', function(e) {
        e.stopPropagation();
    });

    $('.btnClose').click(function(e) {
        e.preventDefault();

        let id = $(this).data('id');
        // console.log(id);
        $.ajax({
            url: "<?= base_url('notifikasi/delnotif'); ?>" + '/' + id,
        });
        this.parentElement.parentElement.remove();

        $('#numberNotif')[0].innerHTML--;
    });
</script>