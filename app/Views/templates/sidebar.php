<ul class="navbar-nav bg-gradient-bsi sidebar sidebar-dark accordion" id="accordionSidebar">

    <?php
    function url($needle)
    {
        return (substr(uri_string(), 0, strlen($needle)) === $needle ? 'active' : '');
    }
    ?>

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('user'); ?>">
        <div class="sidebar-brand-icon mx-3">
            <img src="<?= base_url() ?>/img/logo-bsi.png" alt="logo-bsi" width="80%" height="80%">
        </div>
        <div class="sidebar-brand-text mx-3">BSI Asset</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        User Profile
    </div>

    <!-- Nav Item - My Profile -->
    <li class="nav-item <?= (substr(uri_string(), 0, strlen('user')) === 'user' || uri_string() === '/' ? 'active' : ''); ?>">
        <a class="nav-link" href="<?= base_url('user'); ?>">
            <i class="fa-solid fa-fw fa-user"></i>
            <span>My Profile</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Kelola Barang
    </div>

    <!-- Nav Item - Notifikasi -->
    <li class="nav-item <?= url('notifikasi'); ?>">
        <a class="nav-link" href="<?= base_url('notifikasi'); ?>">
            <i class="fa-solid fa-fw fa-bell"></i>
            <span>Notifikasi</span></a>
    </li>

    <!-- Nav Item - Kelola Aset -->
    <li class="nav-item <?= url('aset'); ?>">
        <a class="nav-link" href="<?= base_url('aset'); ?>">
            <i class="fa-solid fa-fw fa-compass-drafting"></i>
            <span>Kelola Aset</span></a>
    </li>

    <!-- Nav Item - Kelola Aset -->
    <li class="nav-item <?= url('sewa'); ?>">
        <a class="nav-link" href="<?= base_url('sewa'); ?>">
            <i class="fa-solid fa-fw fa-truck-ramp-box"></i>
            <span>Sewa Barang</span></a>
    </li>

    <!-- Nav Item - Barang Cetakan -->
    <li class="nav-item <?= url('cetak'); ?>">
        <a class="nav-link" href="<?= base_url('cetak'); ?>">
            <i class="fa-solid fa-fw fa-dice-d6"></i>
            <span>Barang Cetakan</span></a>
    </li>

    <!-- Nav Item - Kategori Barang -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="<? // echo base_url('kategori'); 
                                    ?>">
            <i class="fa-solid fa-fw fa-list"></i>
            <span>Kategori Barang</span></a>
    </li> -->

    <?php // if (in_groups('admin')) : 
    ?>
    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading"> -->
    <!-- Admin Panel -->
    <!-- </div> -->

    <!-- Nav Item - User List -->
    <!-- <li class="nav-item <?php // echo url('admin'); 
                                ?>"> -->
    <!-- <a class="nav-link" href="<?php // echo base_url('admin'); 
                                    ?>"> -->
    <!-- <i class="fa-solid fa-fw fa-users"></i> -->
    <!-- <span>User List</span></a> -->
    <!-- </li> -->
    <?php // endif; 
    ?>

    <!-- Divider -->
    <!-- <hr class="sidebar-divider"> -->

    <!-- Heading -->
    <!-- <div class="sidebar-heading"> -->
    <!-- Settings -->
    <!-- </div> -->

    <!-- Nav Item - Logout -->
    <!-- <li class="nav-item <?php //echo url('logout'); 
                                ?>"> -->
    <!-- <a class="nav-link" href="<?php //echo base_url('logout'); 
                                    ?>"> -->
    <!-- <i class="fa-solid fa-fw fa-right-from-bracket"></i> -->
    <!-- <span>Logout</span></a> -->
    <!-- </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>