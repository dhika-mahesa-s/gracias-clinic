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
