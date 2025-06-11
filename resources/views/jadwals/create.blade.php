@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Tambah Jadwal</h1>

    <form action="{{ route('jadwals.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="konselor_id" class="form-label">Pilih Konselor</label>
            <select class="form-select" name="konselor_id" id="konselor_id" required>
                <option value="" disabled selected>Pilih Konselor</option>
                @foreach($konselors as $konselor)
                    <option value="{{ $konselor->id_konselor }}">{{ $konselor->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="hari" class="form-label">Pilih Hari</label>
            <div class="form-check">
                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                    <input class="form-check-input" type="checkbox" name="hari[]" value="{{ $day }}" id="day_{{ $day }}">
                    <label class="form-check-label" for="day_{{ $day }}">{{ $day }}</label><br>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label for="waktu" class="form-label">Pilih Waktu Mulai</label>
            <input type="time" class="form-control" id="waktu" name="waktu[]" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
@endsection
