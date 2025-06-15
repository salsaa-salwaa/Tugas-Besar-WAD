@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Daftar Sesi Janji Temu</h1>

    {{-- Tombol Aksi di bawah judul --}}
    <div class="mb-4">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
        {{-- Tombol Tambah Sesi hanya ditampilkan untuk mahasiswa, sesuai pengaturan rute --}}
        @if(Auth::user()->role === 'mahasiswa')

        @endif
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Card untuk Tabel --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>Nama Mahasiswa</th>
                            <th>Jadwal Konselor</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            {{-- Kolom Aksi hanya akan muncul untuk Admin --}}
                            @if (Auth::user()->role === 'admin')
                                <th>Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->mahasiswa->nama ?? 'N/A' }}</td>
                                <td>
                                    {{-- Menampilkan detail jadwal dengan lebih informatif --}}
                                    @if($appointment->jadwal)
                                        {{ $appointment->jadwal->konselor->nama ?? 'N/A' }} <br>
                                        <small class="text-muted">{{ $appointment->jadwal->hari }}, {{ \Carbon\Carbon::parse($appointment->jadwal->waktu)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->jadwal->waktu_selesai)->format('H:i') }}</small>
                                    @else
                                        <span class="text-danger">Jadwal tidak tersedia</span>
                                    @endif
                                </td>
                                <td>{{ $appointment->deskripsi ?? '-' }}</td>
                                <td>{{ ucfirst($appointment->tipe) }}</td>
                                
                                {{-- Tombol Edit & Hapus hanya untuk Admin --}}
                                @if (Auth::user()->role === 'admin')
                                    <td>
                                        <a href="{{ route('appointments.edit', $appointment->id_appointment) }}" class="btn btn-warning btn-sm mb-1 d-block">Edit</a>
                                        <form action="{{ route('appointments.destroy', $appointment->id_appointment) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sesi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm d-block w-100">Hapus</button>
                                        </form>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                {{-- Menyesuaikan pesan berdasarkan peran pengguna dan jumlah kolom --}}
                                <td colspan="{{ Auth::user()->role === 'admin' ? '5' : '4' }}" class="text-center">
                                    @if(Auth::user()->role === 'mahasiswa')
                                        Anda belum memiliki sesi janji temu.
                                    @else
                                        Tidak ada data sesi yang tersedia.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
