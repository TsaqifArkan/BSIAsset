<ul class="navbar-nav bg-gradient-bsi sidebar sidebar-dark accordion parent-active-toggler" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-database"></i>
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
    <li class="nav-item active-toggler">
        <a class="nav-link default-a-index" href="<?= base_url('user'); ?>">
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
    <li class="nav-item active-toggler">
        <a class="nav-link" href="<?= base_url('notifikasi'); ?>">
            <i class="fa-solid fa-fw fa-bell"></i>
            <span>Notifikasi</span></a>
    </li>

    <!-- Nav Item - Kelola Aset -->
    <li class="nav-item active-toggler">
        <a class="nav-link" href="<?= base_url('aset'); ?>">
            <i class="fa-solid fa-fw fa-compass-drafting"></i>
            <span>Kelola Aset</span></a>
    </li>

    <!-- Nav Item - Kelola Aset -->
    <li class="nav-item active-toggler">
        <a class="nav-link" href="<?= base_url('sewa'); ?>">
            <i class="fa-solid fa-fw fa-truck-ramp-box"></i>
            <span>Sewa Barang</span></a>
    </li>

    <!-- Nav Item - Barang Cetakan -->
    <li class="nav-item active-toggler">
        <a class="nav-link" href="<?= base_url('cetak'); ?>">
            <i class="fa-solid fa-fw fa-dice-d6"></i>
            <span>Barang Cetakan</span></a>
    </li>

    <!-- Nav Item - Kategori Barang -->
    <li class="nav-item active-toggler">
        <a class="nav-link" href="<?= base_url('kategori'); ?>">
            <i class="fa-solid fa-fw fa-list"></i>
            <span>Kategori Barang</span></a>
    </li>

    <?php if (in_groups('admin')) : ?>
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Admin Panel
        </div>

        <!-- Nav Item - User List -->
        <li class="nav-item active-toggler">
            <a class="nav-link" href="<?= base_url('admin'); ?>">
                <i class="fa-solid fa-fw fa-users"></i>
                <span>User List</span></a>
        </li>
    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>

    <!-- Nav Item - Logout -->
    <li class="nav-item active-toggler">
        <a class="nav-link" href="<?= base_url('logout'); ?>">
            <i class="fa-solid fa-fw fa-right-from-bracket"></i>
            <span>Logout</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>