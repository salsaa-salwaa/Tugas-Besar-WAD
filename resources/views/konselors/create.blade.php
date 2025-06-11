@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Tambah Konselor</h1>

    <form action="{{ route('konselors.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ old('no_telp') }}" required>
        </div>

        <div class="mb-3">
            <label for="keahlian" class="form-label">Keahlian</label><br>
            <input type="checkbox" name="keahlian[]" value="akademik" {{ in_array('akademik', old('keahlian', [])) ? 'checked' : '' }}> Akademik<br>
            <input type="checkbox" name="keahlian[]" value="karir" {{ in_array('karir', old('keahlian', [])) ? 'checked' : '' }}> Karir<br>
            <input type="checkbox" name="keahlian[]" value="kecemasan" {{ in_array('kecemasan', old('keahlian', [])) ? 'checked' : '' }}> Kecemasan<br>
            <input type="checkbox" name="keahlian[]" value="emosi" {{ in_array('emosi', old('keahlian', [])) ? 'checked' : '' }}> Emosi<br>
            <input type="checkbox" name="keahlian[]" value="griefing" {{ in_array('griefing', old('keahlian', [])) ? 'checked' : '' }}> Griefing<br>
            <input type="checkbox" name="keahlian[]" value="self-development" {{ in_array('self-development', old('keahlian', [])) ? 'checked' : '' }}> Self Development<br>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
@endsection
