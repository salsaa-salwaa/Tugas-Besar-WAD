@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Daftar Sesi Janji Temu</h1>

    {{-- Tombol Aksi --}}
    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>

        @if(Auth::user()->role === 'mahasiswa')
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">Buat Janji Temu</a>
        @endif
    </div>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- Card untuk Tabel --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered mb-0">
                    <thead>
                        <tr>
                            @if (Auth::user()->role === 'admin')
                                <th>Nama Mahasiswa</th>
                            @endif
                            <th>Konselor</th>
                            <th>Hari</th>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Deskripsi</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($appointments as $appointment)
                            <tr>
                                @if (Auth::user()->role === 'admin')
                                    <td>{{ $appointment->mahasiswa->name ?? '-' }}</td>
                                @endif
                                <td>{{ $appointment->jadwal->konselor->nama ?? '-' }}</td>
                                <td>{{ $appointment->jadwal->hari ?? '-' }}</td>
                                <td>{{ $appointment->tanggal }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($appointment->jadwal->waktu)->format('H:i') }}
                                    - {{ \Carbon\Carbon::parse($appointment->jadwal->waktu_selesai)->format('H:i') }}
                                </td>
                                <td>{{ $appointment->deskripsi ?? '-' }}</td>
                                <td>{{ ucfirst($appointment->tipe) }}</td>
                                <td>
                                    @if ($appointment->status === 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif ($appointment->status === 'disetujui')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    @if (Auth::user()->role === 'mahasiswa')
                                        @if ($appointment->status === 'pending')
                                            <form action="{{ route('appointments.cancel', $appointment->id_appointment) }}" method="POST" onsubmit="return confirm('Batalkan janji temu ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-warning btn-sm">Batalkan</button>
                                            </form>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    @elseif (Auth::user()->role === 'admin')
                                        @if ($appointment->status === 'pending')
                                            <form action="{{ route('appointments.acc', $appointment->id_appointment) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button name="status" value="disetujui" class="btn btn-success btn-sm">Setujui</button>
                                                <button name="status" value="ditolak" class="btn btn-danger btn-sm">Tolak</button>
                                            </form>
                                        @endif
                                        <!-- <a href="{{ route('appointments.edit', $appointment->id_appointment) }}" class="btn btn-warning btn-sm">Edit</a> -->
                                        <form action="{{ route('appointments.destroy', $appointment->id_appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus janji temu ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->role === 'admin' ? '9' : '8' }}" class="text-center">
                                    Belum ada sesi janji temu.
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
