@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Beri Feedback</h1>

    {{-- Tombol Kembali di bawah judul --}}
    <div class="mb-4">
        <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Notifikasi Error Validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card untuk membungkus form --}}
    <div class="card">
        <div class="card-body">
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="konselor_id" class="form-label">Pilih Konselor</label>
                    <select name="konselor_id" id="konselor_id" class="form-select" required>
                        <option value="" disabled selected>-- Pilih Konselor --</option>
                        @foreach ($konselors as $konselor)
                            <option value="{{ $konselor->id_konselor }}">{{ $konselor->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="rating" class="form-label">Rating (1-5)</label>
                    <input type="number" name="rating" id="rating" class="form-control" min="1" max="5" required>
                </div>

                <div class="mb-3">
                    <label for="komentar" class="form-label">Komentar (opsional)</label>
                    <textarea name="komentar" id="komentar" rows="4" class="form-control"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Kirim Feedback</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
