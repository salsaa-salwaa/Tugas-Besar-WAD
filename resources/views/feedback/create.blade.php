@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Beri Feedback</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

    <form action="{{ route('feedback.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="konselor_id" class="form-label">Pilih Konselor</label>
            <select name="konselor_id" id="konselor_id" class="form-select" required>
                <option value="">-- Pilih Konselor --</option>
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

        <button type="submit" class="btn btn-primary">Kirim Feedback</button>
    </form>
</div>
@endsection
