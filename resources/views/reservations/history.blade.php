@extends('layouts.app')

@section('title', 'Riwayat Reservasi')

@section('content')
<div class="page-hero">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Riwayat Reservasi</h2>
                <small>Your Beauty, Our Priority</small>
            </div>
        </div>

        {{-- SEARCH --}}
        <div class="row mt-3 g-3 align-items-center">
            <div class="col-lg-8 col-md-8">
                <form action="{{ route('reservations.history') }}" method="GET" class="d-flex search-bar align-items-center">
                    <i class="bi bi-search text-muted me-2"></i>
                    <input type="text" name="search" class="form-control border-0" placeholder="Cari by ID, treatment, atau dokter..." value="{{ request('search') }}">
                    <button class="btn btn-outline-secondary ms-2" type="submit">Cari</button>
                </form>
            </div>

            <div class="col-lg-4 col-md-4 d-flex justify-content-end">
                <a class="btn btn-light" data-bs-toggle="collapse" href="#filtersArea" role="button" aria-expanded="false" aria-controls="filtersArea">
                    <i class="bi bi-funnel"></i> Filter
                </a>
            </div>
        </div>

        {{-- FILTERS (collapse) --}}
        <div class="collapse filter-row" id="filtersArea">
            <form action="{{ route('reservations.history') }}" method="GET" class="row g-2 align-items-end mt-3">
                <div class="col-md-3">
                    <label class="form-label text-white small">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="Pending" {{ request('status')=='Pending'?'selected':'' }}>Pending</option>
                        <option value="Dikonfirmasi" {{ request('status')=='Dikonfirmasi'?'selected':'' }}>Dikonfirmasi</option>
                        <option value="Selesai" {{ request('status')=='Selesai'?'selected':'' }}>Selesai</option>
                        <option value="Dibatalkan" {{ request('status')=='Dibatalkan'?'selected':'' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label text-white small">Tanggal</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-md-3">
                    <label class="form-label text-white small">Treatment</label>
                    <select name="treatment_id" class="form-select">
                        <option value="">Semua Treatment</option>
                        @if(class_exists(\App\Models\Treatment::class))
                        @foreach(\App\Models\Treatment::all() as $t)
                        <option value="{{ $t->id }}" {{ request('treatment_id') == $t->id ? 'selected':'' }}>{{ $t->name }}</option>
                        @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3 d-grid">
                    <button class="btn btn-light">Terapkan Filter</button>
                </div>
            </form>
        </div>

        {{-- STATS --}}
        <div class="row mt-4 g-3">
            <div class="col-md-3">
                <div class="stat-card">
                    <h3>{{ $stats['total'] ?? 0 }}</h3>
                    <small>Total Reservasi</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <h3 class="text-success">{{ $stats['done'] ?? 0 }}</h3>
                    <small>Selesai</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <h3 class="text-primary">{{ $stats['upcoming'] ?? 0 }}</h3>
                    <small>Mendatang</small>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card">
                    <h3 class="text-danger">{{ $stats['cancelled'] ?? 0 }}</h3>
                    <small>Dibatalkan</small>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MAIN LIST --}}
<div class="container my-4">
    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    @if(isset($reservations) && $reservations->count() > 0)
    @foreach($reservations as $r)
    <div class="card card-res p-4 mb-3">
        <div class="d-flex justify-content-between">
            <div>
                <h5 class="mb-1">{{ optional($r->treatment)->name ?? '—' }}</h5>

                <span class="badge badge-status
              @if($r->status=='Selesai') bg-success text-white
              @elseif($r->status=='Dikonfirmasi') bg-primary text-white
              @elseif($r->status=='Pending') bg-warning text-dark
              @else bg-danger text-white @endif">
                    {{ $r->status }}
                </span>

                <div class="mt-2 text-muted">
                    <i class="bi bi-calendar"></i> {{ optional($r->tanggal)->format('d M Y') ?? '-' }} &nbsp; • &nbsp;
                    <i class="bi bi-person"></i> {{ optional($r->doctor)->name ?? 'Dr. -' }}
                    <br>
                    Booking ID: {{ $r->booking_id }} • Dibuat: {{ $r->created_at ? $r->created_at->format('d M Y') : '-' }}
                </div>
            </div>

            <div class="text-end">
                <div><i class="bi bi-clock"></i> {{ \Carbon\Carbon::parse($r->waktu)->format('H:i') }}</div>
                <div class="fw-semibold mt-2">Rp {{ number_format($r->harga ?? 0,0,',','.') }}</div>

                <div class="mt-3">
                    <button class="btn btn-outline-secondary btn-sm" data-id="{{ $r->id }}" onclick="openDetail(this.dataset.id)"><i class="bi bi-eye"></i> Detail</button>

                    @if(in_array($r->status, ['Pending','Dikonfirmasi']) && auth()->check() && auth()->id() == $r->user_id)
                    <form action="{{ route('reservations.cancel', $r) }}" method="POST" class="d-inline" onsubmit="return confirm('Batalkan reservasi ini?')">
                        @csrf
                        <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i> Batal</button>
                    </form>
                    @elseif(in_array($r->status, ['Pending','Dikonfirmasi']) && !auth()->check())
                    <button class="btn btn-outline-secondary btn-sm" disabled title="Login diperlukan untuk membatalkan"><i class="bi bi-lock"></i> Batal</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div class="d-flex justify-content-center mt-3">
        {{ $reservations->links() }}
    </div>

    @else
    <div class="card card-res p-4 text-center">
        <h5>Belum ada riwayat reservasi</h5>
        <a href="{{ route('reservations.create') }}" class="btn btn-outline-light mt-2">Buat Reservasi</a>
    </div>
    @endif
</div>

{{-- DETAIL MODAL --}}
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-secondary" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- inline script (no @push) --}}
{{--
<script>
    function openDetail(id) {
        const modalEl = document.getElementById('detailModal');
        const modal = new bootstrap.Modal(modalEl);
        document.getElementById('detailContent').innerHTML = '<div class="text-center py-4"><div class="spinner-border text-secondary" role="status"></div></div>';

        fetch('/reservations/' + id, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => {
                if (!r.ok) throw new Error('Gagal memuat');
                return r.json();
            })
            .then(data => {
                const html = `
          <h5>${data.treatment ? data.treatment.name : '-'}</h5>
          <p><strong>Status:</strong> ${data.status}</p>
          <p><i class="bi bi-calendar"></i> ${new Date(data.tanggal).toLocaleDateString('id-ID')}</p>
          <p><i class="bi bi-clock"></i> ${data.waktu}</p>
          <p><i class="bi bi-person"></i> ${data.doctor ? data.doctor.name : '-'}</p>
          <p><strong>Harga:</strong> Rp ${Number(data.harga || 0).toLocaleString('id-ID')}</p>
          <p><strong>Booking ID:</strong> ${data.booking_id}</p>
          <p><strong>Catatan:</strong> ${data.notes ?? '-'}</p>
        `;
                document.getElementById('detailContent').innerHTML = html;
                modal.show();
            })
            .catch(() => {
                document.getElementById('detailContent').innerHTML = '<div class="alert alert-danger">Gagal memuat data.</div>';
                modal.show();
            });
    }
</script>
--}}
<script src="{{ asset('js/reservations-history.js') }}"></script>

@endsection