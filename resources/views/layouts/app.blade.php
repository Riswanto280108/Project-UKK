<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bako Mart | @yield('title')</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #d1d5db;
    }

    /* Sidebar */
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background-color: #163e7d;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: 0.3s;
    }

    .sidebar a {
      color: #cbd5e1;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 12px 20px;
      border-radius: 8px;
      margin: 4px 12px;
      font-size: 15px;
      transition: 0.2s;
    }

    .sidebar a:hover,
    .sidebar a.active {
      background-color: #334155;
      color: #fff;
    }

    .logo {
      font-weight: bold;
      font-size: 1.3rem;
      color: #fff;
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid #334155;
    }

    .logo img {
      width: 100px;          /* diameter lingkaran */
    height: 100px;         /* wajib sama dengan width */
    border-radius: 50%;    /* membuat bulat */
    object-fit: cover;  
      filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.3));
    }

    /* Navbar */
    .navbar {
      margin-left: 250px;
      background-color: #ebebebff;
      filter: drop-shadow(0px 2px 4px rgba(0,0,0,0.3));
    }

    /* Main Content */
    main {
      margin-left: 250px;
      padding: 30px;
    }
  </style>
</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>

  {{-- Sidebar --}}
  <div class="sidebar">
    <div>

      {{-- Logo --}}
      <div class="logo d-flex flex-column align-items-center">
        <img src="{{ asset('logo.jpg') }}" alt="Logo Bako Mart">
        <div class="mt-2">Bako Mart</div>
      </div>

      {{-- Menu Navigasi --}}
      <a href="{{ route('kasir.dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
         Beranda
      </a>

      <a href="{{ route('kategori.index') }}" class="{{ request()->is('kategori') ? 'active' : '' }}">
         Kategori
      </a>

      <a href="{{ route('barang.index') }}" class="{{ request()->is('barang') ? 'active' : '' }}">
         Barang
      </a>

      <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}">
         Transaksi
      </a>

      <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan') ? 'active' : '' }}">
         Laporan
      </a>

    </div>

    {{-- Logout Button --}}
    <form method="POST" action="{{ route('kasir.logout') }}">
      @csrf
      <button type="submit" class="btn btn-danger m-3">Logout</button>
    </form>
  </div>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg shadow-sm px-4 py-2">
    <div class="container-fluid">
      <span class="navbar-brand text-black">Dashboard Kasir</span>
    </div>
  </nav>

  {{-- Main Content --}}
  <main>
    @yield('content')
  </main>

</body>
</html>

