@extends('layouts.app')

@section('content')
    <h1 class="text-center mb-5">Dashboard</h1>

    <div class="row g-4">
        {{-- Card Pengguna --}}
        <div class="col-md-3">
            <div class="card text-white shadow" style="background-color: #2563EB;">
                <div class="card-body">
                    <h5 class="card-title">Pengguna</h5>
                    <h2 class="card-text">{{ $usersCount }}</h2>
                    <a href="{{ url('/users') }}" class="btn btn-light btn-sm mt-3">Tampilkan Pengguna</a>
                </div>
            </div>
        </div>

        {{-- Card Konselor --}}
        <div class="col-md-3">
            <div class="card text-white shadow" style="background-color: #22C55E;">
                <div class="card-body">
                    <h5 class="card-title">Konselor</h5>
                    <h2 class="card-text">{{ $konselorsCount }}</h2>
                    <a href="{{ url('/konselors') }}" class="btn btn-light btn-sm mt-3">Tampilkan Konselor</a>
                </div>
            </div>
        </div>

        {{-- Card Jadwal --}}
        <div class="col-md-3">
            <div class="card text-white shadow" style="background-color: #EAB308;">
                <div class="card-body">
                    <h5 class="card-title">Jadwal</h5>
                    <h2 class="card-text">{{ $jadwalsCount }}</h2>
                    <a href="{{ url('/jadwals') }}" class="btn btn-light btn-sm mt-3">Tampilkan Jadwal</a>
                </div>
            </div>
        </div>

        {{-- Card Sesi --}}
        <div class="col-md-3">
            <div class="card text-white shadow" style="background-color: #06B6D4;">
                <div class="card-body">
                    <h5 class="card-title">Sesi</h5>
                    <h2 class="card-text">{{ $appointmentsCount }}</h2>
                    <a href="{{ url('/sesis') }}" class="btn btn-light btn-sm mt-3">Tampilkan Sesi</a>
                </div>
            </div>
        </div>
    </div>
@endsection
