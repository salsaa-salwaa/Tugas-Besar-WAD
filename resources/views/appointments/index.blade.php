@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Daftar Appointment</h1>

    <div class="text-end mb-3">
        <a href="{{ route('appointments.create') }}" class="btn btn-primary">Tambah Appointment</a>
    </div>

    <!-- Tabel Appointment -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Jadwal</th>
                    <th>Deskripsi</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->mahasiswa->nama }}</td>
                        <td>{{ $appointment->jadwal->hari }} - {{ $appointment->jadwal->waktu }}</td>
                        <td>{{ $appointment->deskripsi }}</td>
                        <td>{{ ucfirst($appointment->tipe) }}</td>
                        <td>
                            <a href="{{ route('appointments.edit', $appointment->id_appointment) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('appointments.destroy', $appointment->id_appointment) }}" method="POST" style="display:inline;">
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
