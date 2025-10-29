@extends('layouts.dashboard')

@section('title', 'Kelola Reservasi - Gracias Aesthetic Clinic')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Kelola Reservasi</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-800 border border-green-300">
            {{ session('success') }}
        </div>
    @elseif(session('info'))
        <div class="mb-4 p-4 rounded-lg bg-blue-100 text-blue-800 border border-blue-300">
            {{ session('info') }}
        </div>
    @elseif(session('error'))
        <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-800 border border-red-300">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel --}}
    <div class="overflow-x-auto rounded-2xl border border-border bg-white shadow-sm">
        <table class="min-w-full text-sm text-left text-gray-800">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-4 py-3">Kode</th>
                    <th class="px-4 py-3">Nama Pelanggan</th>
                    <th class="px-4 py-3">Treatment</th>
                    <th class="px-4 py-3">Dokter</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($reservations as $r)
                    <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium">{{ $r->reservation_code }}</td>
                        <td class="px-4 py-3">{{ $r->customer_name }}</td>
                        <td class="px-4 py-3">{{ $r->treatment->name }}</td>
                        <td class="px-4 py-3">{{ $r->doctor->name }}</td>
                        <td class="px-4 py-3">{{ \Carbon\Carbon::parse($r->reservation_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3">{{ $r->reservation_time }}</td>
                        <td class="px-4 py-3">
                            @switch($r->status)
                                @case('pending')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    @break
                                @case('confirmed')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Confirmed
                                    </span>
                                    @break
                                @case('completed')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Completed
                                    </span>
                                    @break
                                @case('cancel')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Cancelled
                                    </span>
                                    @break
                            @endswitch
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="px-4 py-3 text-center">
                            <div class="flex justify-center flex-wrap gap-2">
                                @if($r->status === 'pending')
                                    <form action="{{ route('admin.reservasi.konfirmasi', $r->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition">
                                            Konfirmasi
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                                            Batalkan
                                        </button>
                                    </form>

                                @elseif($r->status === 'confirmed')
                                    <form action="{{ route('admin.reservasi.selesai', $r->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-green-500 hover:bg-green-600 rounded-lg transition">
                                            Tandai Selesai
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.reservasi.batalkan', $r->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                                            Batalkan
                                        </button>
                                    </form>

                                @else
                                    <button disabled
                                        class="px-3 py-1.5 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                        Tidak ada aksi
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">
                            Belum ada data reservasi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $reservations->links('vendor.pagination.tailwind') }}
    </div>
@endsection
