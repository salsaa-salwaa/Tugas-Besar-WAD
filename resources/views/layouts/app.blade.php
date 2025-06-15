<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Konselor Kita')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #007bff, #00c6ff);
            min-height: 100vh;
            color: #fff;
        }
        .navbar, .dropdown-menu {
            background-color: #1a1a1a !important;
        }
        .navbar-brand {
            font-weight: bold;
            color: #ffc107 !important;
        }
        .navbar-nav .nav-link.active {
            color: #ffc107 !important;
        }
        main.container {
            background-color: white;
            border-radius: 16px;
            padding: 2rem;
            color: #000;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .dropdown-menu {
        background-color: #ffffff !important;
        color: #000000 !important;
        border-radius: 0.5rem;
        box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
        }

        .dropdown-menu .dropdown-item {
            color: #000000 !important;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #000000;
        }

        .dropdown-divider {
            border-color: #dee2e6;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <span class="navbar-brand fw-bold">Konselor Kita</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">

                    @guest
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard*') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>

                        @if(Auth::user()->role == 'admin')
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('users*') || request()->is('konselors*') || request()->is('jadwals*') ? 'active' : '' }}"
                                   href="#" id="masterDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Data Master
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{ url('/users') }}">Pengguna</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/konselors') }}">Konselor</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/jadwals') }}">Jadwal</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/appointments') }}">Sesi</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/feedback') }}">Feedback</a></li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profil</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest

                </ul>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container my-5">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
