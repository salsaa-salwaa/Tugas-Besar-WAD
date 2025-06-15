@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Buat Janji Temu Baru</h1>

    <a href="{{ route('appointments.index') }}" class="btn btn-secondary mb-3">← Kembali ke Daftar</a>

    {{-- Flash message untuk error dan success --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Error dari validasi --}}
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
            <form method="POST" action="{{ route('appointments.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal Konsultasi</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    <small class="text-muted">* Hanya hari kerja (Senin – Jumat)</small>
                </div>

                <div class="mb-3">
                    <label for="jadwal_id" class="form-label">Pilih Jadwal Konselor</label>
                    <select name="jadwal_id" id="jadwal_id" class="form-select" required>
                        <option value="" disabled selected>Pilih jadwal...</option>
                        @foreach($jadwals as $jadwal)
                            <option value="{{ $jadwal->id_jadwal }}">
                                {{ $jadwal->konselor->nama }} - {{ $jadwal->hari }} ({{ \Carbon\Carbon::parse($jadwal->waktu)->format('H:i') }})
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">* Jadwal akan difilter otomatis berdasarkan tanggal</small>
                </div>

                <div class="mb-3">
                    <label for="tipe" class="form-label">Tipe Konsultasi</label>
                    <select name="tipe" id="tipe" class="form-select" required>
                        <option value="daring">Daring</option>
                        <option value="luring">Luring</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi Permasalahan (Opsional)</label>
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Ajukan Janji Temu</button>
            </form>
        </div>
    </div>
</div>

{{-- Script untuk filter hari kerja dan filter jadwal berdasarkan hari --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tanggalInput = document.getElementById('tanggal');
        const jadwalSelect = document.getElementById('jadwal_id');
        const allOptions = Array.from(jadwalSelect.options);

        tanggalInput.addEventListener('change', function () {
            const selectedDate = new Date(this.value);
            const day = selectedDate.getDay(); // 0 = Minggu, 6 = Sabtu

            if (day === 0 || day === 6) {
                alert('Silakan pilih tanggal pada hari kerja (Senin - Jumat)');
                this.value = '';
                jadwalSelect.innerHTML = '<option value="" disabled selected>Pilih jadwal...</option>';
                return;
            }

            const hariIndo = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
            const namaHari = hariIndo[day];

            // Reset pilihan jadwal
            jadwalSelect.innerHTML = '<option value="" disabled selected>Pilih jadwal...</option>';
            allOptions.forEach(opt => {
                if (opt.text.includes(namaHari)) {
                    jadwalSelect.appendChild(opt);
                }
            });
        });
    });
</script>
@endsection
