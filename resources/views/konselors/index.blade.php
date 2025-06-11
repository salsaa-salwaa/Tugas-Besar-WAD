@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Daftar Konselor</h1>

    <!-- Tombol Add di sebelah kanan -->
    <div class="text-end mb-3">
        <a href="{{ route('konselors.create') }}" class="btn btn-primary">Tambah Konselor</a>
    </div>

    <!-- Tabel Konselor -->
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>No. Telepon</th>
                    <th>Keahlian</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($konselors as $konselor)
                    <tr>
                        <td>{{ $konselor->nama }}</td>
                        <td>{{ $konselor->no_telp }}</td>
                        <td>{{ implode(', ', json_decode($konselor->keahlian)) }}</td>
                        <td>
                            <a href="{{ route('konselors.edit', $konselor->id_konselor) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('konselors.destroy', $konselor->id_konselor) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
