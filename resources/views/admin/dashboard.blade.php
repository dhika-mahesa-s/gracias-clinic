<<<<<<< HEAD
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Custom Style --}}
    <style>
      body {
        font-family: 'Segoe UI', sans-serif;
        background-color: #f8f9fa;
      }
      .sidebar {
        height: 100vh;
        background-color: #343a40;
        color: #fff;
        position: fixed;
        width: 230px;
        padding-top: 20px;
      }
      .sidebar h4 {
        text-align: center;
        margin-bottom: 20px;
        font-weight: 600;
      }
      .sidebar a {
        color: #fff;
        text-decoration: none;
        display: block;
        padding: 10px 20px;
        transition: 0.2s;
      }
      .sidebar a:hover {
        background-color: #495057;
      }
      .content {
        margin-left: 230px;
        padding: 30px;
      }
      .navbar {
        background-color: #fff;
        border-bottom: 1px solid #dee2e6;
      }
      .card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      }
      .chart-card {
        background-color: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        padding: 20px;
      }
    </style>
  </head>
  <body>
    {{-- Sidebar --}}
    <div class="sidebar">
      <h4>Admin Panel</h4>
      <a href="#">🏠 Dashboard</a>
      <a href="#">📋 Data Reservasi</a>
      <a href="#">💅 Layanan</a>
      <a href="#">👩‍💻 Pengguna</a>
      <a href="#">⚙️ Pengaturan</a>
    </div>

    {{-- Konten Utama --}}
    <div class="content">
      {{-- Navbar --}}
      <nav class="navbar navbar-expand-lg navbar-light mb-4">
        <div class="container-fluid">
          <span class="navbar-brand fw-semibold">Dashboard</span>
          <div>
            <span class="me-3">Halo, Admin</span>
            <button class="btn btn-outline-danger btn-sm">Logout</button>
          </div>
        </div>
      </nav>

      {{-- Statistik Ringkas --}}
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h6>Total Reservasi</h6>
            <h3>1,245</h3>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h6>Pendapatan Bulan Ini</h6>
            <h3>Rp 12.500.000</h3>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h6>Pengguna Aktif</h6>
            <h3>358</h3>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card p-3 text-center">
            <h6>Layanan Populer</h6>
            <h3>Facial Glow</h3>
          </div>
        </div>
      </div>

      {{-- Grafik --}}
      <div class="chart-card">
        <h5 class="mb-3">Statistik Reservasi Per Bulan</h5>
        <canvas id="reservasiChart" height="100"></canvas>
      </div>
    </div>

    {{-- Script --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      const ctx = document.getElementById('reservasiChart');
      new Chart(ctx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
          datasets: [{
            label: 'Jumlah Reservasi',
            data: [120, 135, 160, 180, 210, 190, 250, 270, 300, 280, 310, 340],
            borderWidth: 1,
            backgroundColor: 'rgba(54, 162, 235, 0.6)',
            borderColor: 'rgba(54, 162, 235, 1)'
          }]
        },
        options: {
          scales: {
            y: { beginAtZero: true }
          }
        }
      });
    </script>
  </body>
</html>
=======
@extends('admin.layout.master')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid p-4">
  <h2 class="mb-4">Dashboard</h2>
  
  <div class="row">
    <div class="col-md-3">
      <div class="card text-center p-3 shadow-sm">
        <h6>Total Reservasi</h6>
        <h3>{{ $total_reservasi }}</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3 shadow-sm">
        <h6>Jumlah Pelanggan</h6>
        <h3>{{ $total_pelanggan }}</h3>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card text-center p-3 shadow-sm">
        <h6>Pendapatan</h6>
        <h3>Rp {{ number_format($pendapatan, 2, ',', '.') }}</h3>
      </div>
    </div>
  </div>
  
  <div class="row mt-4">
    <div class="col-md-6">
      <canvas id="chartLayanan"></canvas>
    </div>
    <div class="col-md-6">
      <canvas id="chartBulan"></canvas>
    </div>
  </div>
  
  <div class="text-center mt-4">
    <button class="btn btn-primary">Unduh Laporan</button>
  </div>
</div>
@endsection
>>>>>>> b8b22b9aa63bc256fd5fe7fe48e52544b8352ceb
