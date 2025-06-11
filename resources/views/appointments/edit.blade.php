@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Appointment</h1>

    <form action="{{ route('appointments.update', $appointment->id_appointment) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">Pilih Mahasiswa</label>
            <select class="form-select" name="mahasiswa_id" id="mahasiswa_id" required>
                <option value="" disabled>Pilih Mahasiswa</option>
                @foreach($mahasiswa as $mhs)
                    <option value="{{ $mhs->id_user }}" {{ $appointment->mahasiswa_id == $mhs->id_user ? 'selected' : '' }}>{{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipe" class="form-label">Pilih Tipe</label>
            <select class="form-select" name="tipe" id="tipe" required>
                <option value="daring" {{ $appointment->tipe == 'daring' ? 'selected' : '' }}>Daring</option>
                <option value="luring" {{ $appointment->tipe == 'luring' ? 'selected' : '' }}>Luring</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jadwal_id" class="form-label">Pilih Jadwal</label>
            <select class="form-select" name="jadwal_id" id="jadwal_id" required>
                <option value="" disabled>Pilih Jadwal</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwal }}" {{ $appointment->jadwal_id == $jadwal->id_jadwal ? 'selected' : '' }}>{{ $jadwal->hari }} - {{ $jadwal->waktu }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3">{{ $appointment->deskripsi }}</textarea>
        </div>

        <button type="submit" class="btn btn-warning">Update Appointment</button>
    </form>
@endsection
