<nav id="sidebar" class="sidebar js-sidebar">
  <div class="sidebar-content js-simplebar">
    <a class="sidebar-brand" href="{{ route('dashboard') }}">
      <span class="align-middle">Futsal App</span>
    </a>

    <ul class="sidebar-nav">
      <li class="sidebar-item {{ Route::is('dashboard') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('dashboard') }}">
          <i class="align-middle" data-feather="grid"></i> <span class="align-middle">Dashboard</span>
        </a>
      </li>

      @can('isAdmin')
      <li class="sidebar-item">
        <a class="sidebar-link" href="#">
          <i class="align-middle" data-feather="users"></i> <span class="align-middle">Pelanggan</span>
        </a>
      </li>

      <li class="sidebar-item {{ Request::is('lapangan*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('lapangan.index') }}">
          <i class="align-middle" data-feather="columns"></i> <span class="align-middle">Lapangan</span>
        </a>
      </li>
      @endcan

      <li class="sidebar-item {{ Request::is('jadwal*') ? 'active' : '' }}">
        <a class="sidebar-link" href="{{ route('jadwal.index') }}">
          <i class="align-middle" data-feather="calendar"></i> <span class="align-middle">Jadwal</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="#">
          <i class="align-middle" data-feather="shopping-bag"></i> <span class="align-middle">Pemesanan</span>
        </a>
      </li>

      <li class="sidebar-item">
        <a class="sidebar-link" href="#">
          <i class="align-middle" data-feather="tag"></i> <span class="align-middle">Laporan</span>
        </a>
      </li>
    </ul>
  </div>
</nav>