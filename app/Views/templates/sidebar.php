<ul class="navbar-nav bg-gradient-bsi sidebar sidebar-dark accordion" id="accordionSidebar">

    <?php
    function url($needle)
    {
        return (substr(uri_string(), 0, strlen($needle)) === $needle ? 'active' : '');
    }
    ?>

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('/'); ?>">
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
    <!-- <li class="nav-item <?php // echo url('notifikasi'); 
                                ?>">
        <a class="nav-link" href="<?php // echo base_url('notifikasi'); 
                                    ?>">
            <i class="fa-solid fa-fw fa-bell"></i>
            <span>Notifikasi</span></a>
    </li> -->

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

    <!-- Nav Item - Data Barang dan Kodenya -->
    <li class="nav-item <?= url('brgcetak'); ?>">
        <a class="nav-link" href="<?= base_url('brgcetak'); ?>">
            <i class="fa-solid fa-fw fa-list"></i>
            <span>Barang Cetak</span></a>
    </li>

    <!-- Nav Item - Transaksi Barang Cetak -->
    <li class="nav-item <?= url('transaksi'); ?>">
        <a class="nav-link" href="<?= base_url('transaksi'); ?>">
            <i class="fa-solid fa-fw fa-dice-d6"></i>
            <span>Transaksi Barang Cetak</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>