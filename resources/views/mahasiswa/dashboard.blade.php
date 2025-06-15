@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
<style>
    body {
        background: linear-gradient(to bottom right, #4facfe, #00f2fe);
    }
    .dashboard-card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
    }
    .dashboard-header {
        background-color: #2563eb;
        color: white;
        padding: 15px;
        font-size: 1.25rem;
        font-weight: 600;
    }
    .dashboard-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 16px;
        border-bottom: 1px solid #ddd;
        transition: background-color 0.2s ease;
    }
    .dashboard-item:last-child {
        border-bottom: none;
    }
    .dashboard-item:hover {
        background-color: #f5f5f5;
    }
    .dashboard-arrow {
        color: #2563eb;
        font-weight: bold;
        font-size: 1.25rem;
    }
</style>

<div class="d-flex justify-content-center align-items-center" style="min-height: 85vh;">
    <div class="card dashboard-card w-75">
        <div class="dashboard-header">
            Dashboard Mahasiswa
        </div>
        <div class="card-body text-center">
            <h5 class="fw-semibold mb-3">Selamat Datang, {{ Auth::user()->nama }}!</h5>
            <p class="text-muted mb-4">Ini adalah halaman dashboard Anda. Silakan gunakan menu di bawah untuk mengakses fitur yang tersedia.</p>
            
            <div class="list-group">

                <a href="{{ url('/jadwals') }}" class="dashboard-item list-group-item list-group-item-action">
                    <span>Lihat Jadwal Konseling</span>
                    <span class="dashboard-arrow">&gt;</span>
                </a>

                <a href="{{ url('/appointments') }}" class="dashboard-item list-group-item list-group-item-action">
                    <span>Lihat Sesi Saya</span>
                    <span class="dashboard-arrow">&gt;</span>
                </a>

                <a href="{{ url('/appointments/create') }}" class="dashboard-item list-group-item list-group-item-action">
                    <span>Buat Sesi Baru</span>
                    <span class="dashboard-arrow">&gt;</span>
                </a>

                <a href="{{ url('/feedback/create') }}" class="dashboard-item list-group-item list-group-item-action">
                    <span>Berikan Feedback</span>
                    <span class="dashboard-arrow">&gt;</span>
                </a>

                <a href="{{ url('/feedback') }}" class="dashboard-item list-group-item list-group-item-action">
                    <span>Lihat Riwayat Feedback</span>
                    <span class="dashboard-arrow">&gt;</span>
                </a>

            </div>
        </div>
    </div>
</div>
@endsection
