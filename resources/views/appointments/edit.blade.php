@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Edit Sesi</h1>
    <div class="mb-4">
        <a href="{{ route('appointments.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('appointments.update', $appointment->id_appointment) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" id="nama_mahasiswa" class="form-control" value="{{ $appointment->mahasiswa?->nama ?? 'N/A' }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="tipe" class="form-label">Pilih Tipe Sesi</label>
                    <select class="form-select" name="tipe" id="tipe" required>
                        <option value="daring" {{ $appointment->tipe == 'daring' ? 'selected' : '' }}>Daring</option>
                        <option value="luring" {{ $appointment->tipe == 'luring' ? 'selected' : '' }}>Luring</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jadwal_id" class="form-label">Pilih Jadwal Konselor</label>
                    <select class="form-select" name="jadwal_id" id="jadwal_id" required>
                        <option value="" disabled>Pilih jadwal yang tersedia...</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id_jadwal }}" {{ $appointment->jadwal_id == $jadwal->id_jadwal ? 'selected' : '' }}>
                                {{ $jadwal->konselor->nama }} - {{ $jadwal->hari }} ({{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat (Opsional)</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi', $appointment->deskripsi) }}</textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Sesi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
