@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Daftar Jadwal</h1>

    <div class="d-flex justify-content-between mb-3">
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        </div>
        <div>
            <a href="{{ route('jadwals.create') }}" class="btn btn-primary">Tambah Jadwal</a>
        </div>
    </div>

    <!-- Tabel Jadwal -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nama Konselor</th>
                    <th>Keahlian Konselor</th>
                    <th>Hari</th>
                    <th>Waktu</th>
                    <th>Waktu Selesai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwal->konselor->nama }}</td>
                        <td>{{ implode(', ', json_decode($jadwal->konselor->keahlian)) }}</td>
                        <td>{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->waktu }}</td>
                        <td>{{ $jadwal->waktu_selesai }}</td>
                        <td>
                            <a href="{{ route('jadwals.edit', $jadwal->id_jadwal) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('jadwals.destroy', $jadwal->id_jadwal) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
