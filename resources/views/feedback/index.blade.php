@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Feedback</h1>
        <a href="{{ route('feedback.create') }}" class="btn btn-primary">+ Buat Feedback</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($feedbacks->isEmpty())
        <div class="alert alert-info">Belum ada feedback yang tersedia.</div>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Mahasiswa</th>
                    <th>Konselor</th>
                    <th>Rating</th>
                    <th>Komentar</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
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
                        <td>
                            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
