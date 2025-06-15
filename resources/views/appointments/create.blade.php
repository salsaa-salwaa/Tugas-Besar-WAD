@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Tambah Sesi</h1>

    {{-- Tombol Kembali di bawah judul --}}
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
    </div>

    {{-- Card untuk membungkus form --}}
    <div class="card">
        <div class="card-body">
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
                            <option value="{{ $jadwal->id_jadwal }}">{{ $jadwal->konselor->nama }} - {{ $jadwal->hari }} ({{ $jadwal->waktu }} - {{ $jadwal->waktu_selesai }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi (opsional)</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Buat Sesi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
