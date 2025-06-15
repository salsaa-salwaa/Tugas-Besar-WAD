@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Edit Janji Temu</h1>

    <a href="{{ route('appointments.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('appointments.update', $appointment->id_appointment) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Konsultasi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $appointment->tanggal }}" required>
                </div>

                <div class="mb-3">
                    <label for="jadwal_id" class="form-label">Pilih Jadwal Konselor</label>
                    <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id_jadwal }}" {{ $jadwal->id_jadwal == $appointment->jadwal_id ? 'selected' : '' }}>
                                {{ $jadwal->konselor->nama }} - {{ $jadwal->hari }} ({{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe Konsultasi</label>
                    <select name="tipe" id="tipe" class="form-select" required>
                        <option value="daring" {{ $appointment->tipe == 'daring' ? 'selected' : '' }}>Daring</option>
                        <option value="luring" {{ $appointment->tipe == 'luring' ? 'selected' : '' }}>Luring</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Permasalahan</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3">{{ $appointment->deskripsi }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary">Perbarui Janji Temu</button>
            </form>
        </div>
    </div>
</div>
@endsection
