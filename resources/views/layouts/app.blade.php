<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bako Mart | @yield('title')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .sidebar {
      width: 250px;
      height: 100vh;
      position: fixed;
      background-color: #163e7d;
      color: #fff;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    .sidebar a {
      color: #cbd5e1;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      border-radius: 8px;
      margin: 4px 12px;
    }
    .sidebar a:hover, .sidebar a.active {
      background-color: #334155;
      color: #fff;
    }
    .navbar {
      margin-left: 250px;
      background-color: #2563EB;
      color: white;
    }
    main {
      margin-left: 250px;
      padding: 30px;
    }
    .logo {
      font-weight: bold;
      font-size: 1.3rem;
      color: #fff;
      padding: 20px;
      text-align: center;
      border-bottom: 1px solid #334155;
    }
  </style>
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>

  {{-- Sidebar --}}
  <div class="sidebar">
    <div>
      <div class="logo">Bako Mart</div>
      <a href="{{ route('kasir.dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"> Beranda</a>
      <a href="{{ route('kategori.index') }}" class="{{ request()->is('kategori') ? 'active' : '' }}"> Kategori</a>
      <a href="{{ route('barang.index') }}" class="{{ request()->is('barang') ? 'active' : '' }}"> Barang</a>
      <a href="{{ route('transaksi.index') }}" class="{{ request()->is('transaksi') ? 'active' : '' }}"> Transaksi</a>
      <a href="{{ route('laporan.index') }}" class="{{ request()->is('laporan') ? 'active' : '' }}"> Laporan</a>
    </div>
    <form method="POST" action="{{ route('kasir.logout') }}">
      @csrf
      <button type="submit" class="btn btn-danger m-3 ">Logout</button>
    </form>
  </div>

  {{-- Navbar --}}
  <nav class="navbar navbar-expand-lg shadow-sm px-4 py-2">
    <div class="container-fluid">
      <span class="navbar-brand text-white">Dashboard Kasir</span>
      
    </div>
  </nav>

  {{-- Main Content --}}
  <main>
    @yield('content')
  </main>

</body>
</html>
