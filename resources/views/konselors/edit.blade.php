@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Edit Konselor</h1>

    <form action="{{ route('konselors.update', $konselor->id_konselor) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $konselor->nama) }}" required>
        </div>

        <div class="mb-3">
            <label for="no_telp" class="form-label">No. Telepon</label>
            <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ old('no_telp', $konselor->no_telp) }}" required>
        </div>

        <div class="mb-3">
            <label for="keahlian" class="form-label">Keahlian</label><br>
            <input type="checkbox" name="keahlian[]" value="akademik" {{ in_array('akademik', old('keahlian', json_decode($konselor->keahlian, true))) ? 'checked' : '' }}> Akademik<br>
            <input type="checkbox" name="keahlian[]" value="karir" {{ in_array('karir', old('keahlian', json_decode($konselor->keahlian, true))) ? 'checked' : '' }}> Karir<br>
            <input type="checkbox" name="keahlian[]" value="kecemasan" {{ in_array('kecemasan', old('keahlian', json_decode($konselor->keahlian, true))) ? 'checked' : '' }}> Kecemasan<br>
            <input type="checkbox" name="keahlian[]" value="emosi" {{ in_array('emosi', old('keahlian', json_decode($konselor->keahlian, true))) ? 'checked' : '' }}> Emosi<br>
            <input type="checkbox" name="keahlian[]" value="griefing" {{ in_array('griefing', old('keahlian', json_decode($konselor->keahlian, true))) ? 'checked' : '' }}> Griefing<br>
            <input type="checkbox" name="keahlian[]" value="self-development" {{ in_array('self-development', old('keahlian', json_decode($konselor->keahlian, true))) ? 'checked' : '' }}> Self Development<br>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection
