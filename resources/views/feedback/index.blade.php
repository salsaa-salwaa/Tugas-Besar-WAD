@extends('layouts.app')

@section('content')
<div class="container">
    {{-- Judul Halaman --}}
    <h1 class="h4 mb-3">Daftar Riwayat Feedback</h1>

    {{-- Tombol Aksi di bawah judul --}}
    <div class="mb-4">
        @if (Auth::user()->role === 'mahasiswa' || Auth::user()->role === 'admin')
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">&larr; Kembali ke Dashboard</a>
        @endif
    </div>

    {{-- Notifikasi Sukses --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan jika tidak ada feedback --}}
    @if ($feedbacks->isEmpty())
        <div class="alert alert-info">
            @if (Auth::user()->role === 'mahasiswa')
                Anda belum pernah memberikan feedback.
            @else
                Belum ada feedback yang tersedia.
            @endif
        </div>
    @else
        {{-- Tabel Riwayat Feedback --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Mahasiswa</th>
                                <th>Konselor</th>
                                <th>Rating <small class="text-muted">(maks. 5)</small></th>
                                <th>Komentar</th>
                                <th>Waktu</th>
                                {{-- Kolom Aksi hanya untuk Admin --}}
                                @if (Auth::user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedbacks as $index => $feedback)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $feedback->mahasiswa->nama ?? '-' }}</td>
                                    <td>{{ $feedback->konselor->nama ?? '-' }}</td>
                                    <td>
                                        @if($feedback->rating > 5)
                                            <span class="text-danger fw-bold">{{ $feedback->rating }} ⚠</span>
                                        @else
                                            {{ $feedback->rating }}
                                        @endif
                                    </td>
                                    <td>{{ $feedback->komentar }}</td>
                                    <td>{{ $feedback->created_at->format('d M Y H:i') }}</td>
                                    {{-- Tombol Hapus hanya untuk Admin --}}
                                    @if (Auth::user()->role === 'admin')
                                        <td>
                                            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus feedback ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
