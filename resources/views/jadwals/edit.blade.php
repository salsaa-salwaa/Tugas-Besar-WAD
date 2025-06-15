@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Edit Jadwal</h1>
    <div class="mb-4">
        <a href="{{ route('jadwals.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    <div class="card">
        <div class="card-body">
            {{-- Form action menunjuk ke rute update dengan method PUT --}}
            <form action="{{ route('jadwals.update', $jadwal->id_jadwal) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="konselor_id" class="form-label">Pilih Konselor</label>
                    <select class="form-select" name="konselor_id" id="konselor_id" required>
                        <option value="" disabled>Pilih Konselor</option>
                        @foreach($konselors as $konselor)
                            {{-- Memilih konselor yang sudah ada --}}
                            <option value="{{ $konselor->id_konselor }}" {{ $jadwal->konselor_id == $konselor->id_konselor ? 'selected' : '' }}>
                                {{ $konselor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="hari" class="form-label">Pilih Hari</label>
                    {{-- Menggunakan dropdown (select) bukan checkbox --}}
                    <select class="form-select" name="hari" id="hari" required>
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                            {{-- Memilih hari yang sudah ada --}}
                            <option value="{{ $day }}" {{ $jadwal->hari == $day ? 'selected' : '' }}>{{ $day }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="waktu" class="form-label">Pilih Waktu Mulai</label>
                    {{-- Input waktu diisi dengan data yang sudah ada --}}
                    <input type="time" class="form-control" id="waktu" name="waktu" value="{{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }}" required>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Update Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
