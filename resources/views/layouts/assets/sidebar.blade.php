<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Kasir <sup>BP</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-solid fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <div class="sidebar-heading">
        Kelola Barang
    </div>
    <li class="nav-item {{ Request::routeIs('admin.jb') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.jb') }}">
            <i class="fas fa-fw fa-solid fa-box"></i>
            <span>Jenis Barang</span></a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.barang') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.barang') }}">
            <i class="fas fa-fw fa-solid fa-cube"></i>
            <span>Barang</span></a>
    </li>
    <div class="sidebar-heading">
        Transaksi
    </div>
    <li class="nav-item {{ Request::routeIs('admin.transaksi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transaksi') }}">
            <i class="fas fa-fw fa-solid fa-comments-dollar"></i>
            <span>Transaksi</span></a>
    </li>
    <li class="nav-item {{ Request::routeIs('admin.daftar_transaksi') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.daftar_transaksi') }}">
            <i class="fas fa-fw fa-solid fa-dollar-sign"></i>
            <span>Daftar Transaksi</span></a>
    </li>
    <div class="sidebar-heading">
        Pengeluaran
    </div>
    <li class="nav-item {{ Request::routeIs('admin.pengeluaran') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengeluaran') }}">
            <i class="fas fa-fw fa-solid fa-file-invoice-dollar"></i>
            <span>Kelola Pengeluaran</span></a>
    </li>
    <div class="sidebar-heading">
        Pemasukkan
    </div>
    <li class="nav-item {{ Request::routeIs('admin.pemasukkan') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pemasukkan') }}">
            <i class="fas fa-fw fa-solid fa-donate"></i>
            <span>Kelola Pemasukkan</span></a>
    </li>
    

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>