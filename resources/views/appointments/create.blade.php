@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Tambah Sesi</h1>

    {{-- Tombol Kembali di bawah judul --}}
    <div class="mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

    {{-- Card untuk membungkus form --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf

                {{-- PERBAIKAN: Menampilkan nama mahasiswa yang login (tidak bisa diedit) --}}
                <div class="mb-3">
                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                    <input type="text" id="nama_mahasiswa" class="form-control" value="{{ Auth::user()->nama }}" disabled>
                </div>

                {{-- Input tersembunyi untuk mengirim ID mahasiswa --}}
                <input type="hidden" name="mahasiswa_id" value="{{ Auth::id() }}">

                <div class="mb-3">
                    <label for="tipe" class="form-label">Pilih Tipe Sesi</label>
                    <select class="form-select" name="tipe" id="tipe" required>
                        <option value="daring">Daring</option>
                        <option value="luring">Luring</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="jadwal_id" class="form-label">Pilih Jadwal Konselor</label>
                    <select class="form-select" name="jadwal_id" id="jadwal_id" required>
                        <option value="" disabled selected>Pilih jadwal yang tersedia...</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id_jadwal }}">
                                {{ $jadwal->konselor->nama }} - {{ $jadwal->hari }} ({{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Singkat (Opsional)</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="Jelaskan secara singkat topik yang ingin Anda diskusikan..."></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Buat Sesi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
