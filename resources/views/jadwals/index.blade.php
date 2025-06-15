@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Daftar Jadwal Konseling</h1>

    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('jadwals.create') }}" class="btn btn-primary ms-2">+ Tambah Jadwal</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Logika untuk membedakan tampilan Admin dan Mahasiswa --}}
    @if(Auth::user()->role === 'admin')
        
        {{-- ======================================================= --}}
        {{-- TAMPILAN TABEL UNTUK ADMIN --}}
        {{-- ======================================================= --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered mb-0">
                        <thead>
                            <tr>
                                <th>Nama Konselor</th>
                                <th>Keahlian</th>
                                <th>Hari</th>
                                <th>Waktu Sesi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Untuk admin, kita loop variabel $jadwals --}}
                            @forelse($jadwals as $jadwal)
                                <tr>
                                    <td>{{ $jadwal->konselor?->nama ?? 'N/A' }}</td>
                                    <td>
                                        @if($jadwal->konselor?->keahlian && json_decode($jadwal->konselor->keahlian))
                                            @foreach(json_decode($jadwal->konselor->keahlian) as $keahlian)
                                                <span class="badge bg-info text-dark">{{ ucfirst($keahlian) }}</span>
                                            @endforeach
                                        @else - @endif
                                    </td>
                                    <td>{{ $jadwal->hari }}</td>
                                    <td>{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }}</td>
                                    <td>
                                        <a href="{{ route('jadwals.edit', $jadwal) }}" class="btn btn-warning btn-sm mb-1 d-inline-block">Edit</a>
                                        <form action="{{ route('jadwals.destroy', $jadwal) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center">Saat ini belum ada jadwal konseling yang tersedia.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @else

        {{-- ======================================================= --}}
        {{-- TAMPILAN CARD UNTUK MAHASISWA (SESUAI GAMBAR) --}}
        {{-- ======================================================= --}}
        <div class="row">
            @forelse ($jadwalsByKonselor as $konselorId => $jadwalGroup)
                <div class="col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0 me-3">
                                    {{-- Placeholder untuk foto --}}
                                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="white" class="bi bi-person-fill" viewBox="0 0 16 16">
                                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                                        </svg>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="card-title">{{ $jadwalGroup->first()->konselor?->nama ?? 'Konselor Tidak Dikenal' }}</h5>
                                    <p class="card-text text-muted">
                                        <strong>Keahlian:</strong> 
                                        @if($jadwalGroup->first()->konselor?->keahlian && json_decode($jadwalGroup->first()->konselor->keahlian))
                                            {{ implode(', ', array_map('ucfirst', json_decode($jadwalGroup->first()->konselor->keahlian))) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <hr>
                            {{-- Mengelompokkan jadwal berdasarkan hari --}}
                            @foreach ($jadwalGroup->groupBy('hari') as $hari => $slots)
                                <div class="row mb-2">
                                    <div class="col-sm-3"><strong>{{ $hari }}:</strong></div>
                                    <div class="col-sm-9">
                                        @foreach ($slots as $slot)
                                            <span class="me-2">{{ \Carbon\Carbon::parse($slot->waktu)->format('H:i') }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @empty
                <div class="col">
                    <div class="alert alert-info">Saat ini belum ada jadwal konseling yang tersedia.</div>
                </div>
            @endforelse
        </div>
    @endif
</div>
@endsection
