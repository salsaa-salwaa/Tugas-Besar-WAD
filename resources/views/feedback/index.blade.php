@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Riwayat Feedback</h1>
        {{-- Tombol Tambah Feedback hanya akan muncul untuk Admin --}}
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('feedback.create') }}" class="btn btn-primary">+ Buat Feedback (Admin)</a>
        @else
            {{-- Untuk Mahasiswa, tombol ini mengarah kembali ke dashboard mereka --}}
            <a href="{{ route('mahasiswa.dashboard') }}" class="btn btn-secondary">Kembali ke Dashboard</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($feedbacks->isEmpty())
        <div class="alert alert-info">
            @if (Auth::user()->role === 'mahasiswa')
                Anda belum pernah memberikan feedback.
            @else
                Belum ada feedback yang tersedia.
            @endif
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa</th>
                        <th>Konselor</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Waktu</th>
                        {{-- Kolom Aksi hanya akan muncul untuk Admin --}}
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
                            <td>{{ $feedback->rating }}</td>
                            <td>{{ $feedback->komentar }}</td>
                            <td>{{ $feedback->created_at->format('d M Y H:i') }}</td>
                            {{-- Tombol Hapus hanya akan muncul untuk Admin --}}
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
    @endif
</div>
@endsection
