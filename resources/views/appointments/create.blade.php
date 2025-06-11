@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Tambah Appointment</h1>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="mahasiswa_id" class="form-label">Pilih Mahasiswa</label>
            <select class="form-select" name="mahasiswa_id" id="mahasiswa_id" required>
                <option value="" disabled selected>Pilih Mahasiswa</option>
                @foreach($mahasiswa as $mhs)
                    <option value="{{ $mhs->id_user }}">{{ $mhs->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipe" class="form-label">Pilih Tipe</label>
            <select class="form-select" name="tipe" id="tipe" required>
                <option value="daring">Daring</option>
                <option value="luring">Luring</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="jadwal_id" class="form-label">Pilih Jadwal</label>
            <select class="form-select" name="jadwal_id" id="jadwal_id" required>
                <option value="" disabled selected>Pilih Jadwal</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id_jadwal }}">{{ $jadwal->hari }} - {{ $jadwal->waktu }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
            <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Buat Appointment</button>
    </form>
@endsection
