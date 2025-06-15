@extends('layouts.app')

@section('content')
    <style>
        .dashboard-card {
            border: none;
            border-radius: 1rem;
            transition: all 0.3s ease-in-out;
            color: #333;
        }

        .dashboard-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-icon {
            font-size: 2rem;
            margin-right: 0.75rem;
        }

        .bg-pastel-blue { background-color: #cfe8fc; }
        .bg-pastel-green { background-color: #d3f8e2; }
        .bg-pastel-yellow { background-color: #fff5ba; }
        .bg-pastel-cyan { background-color: #cbf1f5; }
        .bg-pastel-purple { background-color: #e0bbf9; }
    </style>

    <h1 class="text-center mb-5">Dashboard</h1>

    <div class="row g-4">
        {{-- Pengguna --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card bg-pastel-blue">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="bi bi-people-fill dashboard-icon"></i> Pengguna
                    </h5>
                    <h2>{{$usersCount}}</h2>
                    <a href="{{ url('/users') }}" class="btn btn-outline-dark btn-sm mt-3">Tampilkan Pengguna</a>
                </div>
            </div>
        </div>

        {{-- Konselor --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card bg-pastel-green">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="bi bi-person-badge-fill dashboard-icon"></i> Konselor
                    </h5>
                    <h2>{{$konselorsCount}}</h2>
                    <a href="{{ url('/konselors') }}" class="btn btn-outline-dark btn-sm mt-3">Tampilkan Konselor</a>
                </div>
            </div>
        </div>

        {{-- Jadwal --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card bg-pastel-yellow">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="bi bi-calendar-event dashboard-icon"></i> Jadwal
                    </h5>
                    <h2>{{$jadwalsCount}}</h2>
                    <a href="{{ url('/jadwals') }}" class="btn btn-outline-dark btn-sm mt-3">Tampilkan Jadwal</a>
                </div>
            </div>
        </div>

        {{-- Sesi --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card bg-pastel-cyan">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="bi bi-chat-dots-fill dashboard-icon"></i> Sesi
                    </h5>
                    <h2>{{$appointmentsCount}}</h2>
                    <a href="{{ url('/appointments') }}" class="btn btn-outline-dark btn-sm mt-3">Tampilkan Sesi</a>
                </div>
            </div>
        </div>

        {{-- Feedback --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card dashboard-card bg-pastel-purple">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center">
                        <i class="bi bi-star-fill dashboard-icon"></i> Feedback
                    </h5>
                    <h2>{{$feedbackCount}}</h2>
                    <a href="{{ url('/feedback') }}" class="btn btn-outline-dark btn-sm mt-3">Tampilkan Feedback</a>
                </div>
            </div>
        </div>
    </div>
@endsection
