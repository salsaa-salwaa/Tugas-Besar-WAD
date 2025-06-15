@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="h4 mb-3">Tambah Jadwal Baru</h1>
    <div class="mb-4">
        <a href="{{ route('jadwals.index') }}" class="btn btn-secondary">&larr; Kembali</a>
    </div>

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
            <form action="{{ route('jadwals.store') }}" method="POST">
                @csrf

                {{-- Pilih Konselor --}}
                <div class="mb-4">
                    <label for="konselor_id" class="form-label">Pilih Konselor</label>
                    <select class="form-select @error('konselor_id') is-invalid @enderror" name="konselor_id" id="konselor_id" required>
                        <option value="" disabled selected>Pilih salah satu konselor...</option>
                        @foreach($konselors as $konselor)
                            <option value="{{ $konselor->id_konselor }}" {{ old('konselor_id') == $konselor->id_konselor ? 'selected' : '' }}>
                                {{ $konselor->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Jadwal Hari dan Jam --}}
                <div class="mb-3">
                    <label class="form-label">Pilih Jadwal Hari dan Jam</label>
                    @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $day)
                        <div class="mb-3 p-3 border rounded">
                            <label class="form-label fw-bold">{{ $day }}</label>
                            <select name="jadwal[{{ $day }}][]" class="form-select" multiple size="5">
                                @foreach (range(8, 16) as $hour)
                                    <option value="{{ sprintf('%02d:00', $hour) }}">{{ sprintf('%02d:00', $hour) }}</option>
                                    {{-- Hanya tambahkan slot :30 jika jam bukan 16:00 --}}
                                    @if($hour < 16)
                                        <option value="{{ sprintf('%02d:30', $hour) }}">{{ sprintf('%02d:30', $hour) }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <small class="text-muted">Gunakan Ctrl (Windows) atau Cmd (Mac) untuk memilih lebih dari satu waktu.</small>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
