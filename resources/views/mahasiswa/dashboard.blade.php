@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h1 class="h4 mb-0">Dashboard Mahasiswa</h1>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <h2 class="h5">Selamat Datang, {{ Auth::user()->nama }}!</h2>
                        <p class="text-muted">Ini adalah halaman dashboard Anda. Silakan gunakan menu di bawah untuk mengakses fitur yang tersedia.</p>
                    </div>

                    <div class="list-group">
                        <a href="{{ route('appointments.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Lihat Janji Temu Saya
                            <span class="badge bg-primary rounded-pill">></span>
                        </a>
                        <a href="{{ route('appointments.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Buat Janji Temu Baru
                            <span class="badge bg-primary rounded-pill">></span>
                        </a>
                        <a href="{{ route('feedback.create') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Berikan Feedback
                            <span class="badge bg-primary rounded-pill">></span>
                        </a>
                         <a href="{{ route('feedback.index') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            Lihat Riwayat Feedback
                            <span class="badge bg-primary rounded-pill">></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
