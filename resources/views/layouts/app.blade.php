<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konselor App</title>
    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Konselor App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">

                    @guest
                        {{-- Tampilkan menu ini hanya jika pengguna BELUM login --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        {{-- Tampilkan menu ini hanya jika pengguna SUDAH login --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard*') || request()->is('admin/dashboard*') || request()->is('mahasiswa/dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        
                        @if(Auth::user()->role == 'admin')
                            {{-- Dropdown Data Master (Hanya untuk Admin) --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('users*') || request()->is('konselors*') || request()->is('jadwals*') ? 'active' : '' }}"
                                   href="#" id="masterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Data Master
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="masterDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/users') }}">Pengguna</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/konselors') }}">Konselor</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/jadwals') }}">Jadwal</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/appointments') }}">Sesi</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/feedback') }}">Feedback</a></li>
                                </ul>
                            </li>
                        @endif

                        {{-- Dropdown untuk menampilkan Nama & Role Pengguna --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    {{-- Form Logout yang Aman --}}
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
