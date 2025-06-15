<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konselor App</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Custom Style --}}
    <style>
        .navbar-pastel {
            background-color: #e2e8f0; /* Soft Gray */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            border-bottom: 1px solid #cbd5e1;
        }

        .navbar-pastel .nav-link {
            color: #1e293b; /* abu gelap */
            font-weight: 500;
        }

        .navbar-pastel .nav-link.active,
        .navbar-pastel .nav-link:hover {
            color: #2563eb; /* biru tegas */
        }

        .navbar-brand {
            font-weight: bold;
            color: #0f172a;
        }

        .navbar-brand:hover {
            color: #1e40af;
        }

        .dropdown-menu {
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-pastel">
        <div class="container">
            <a class="navbar-brand" href="/">Konselor Kita</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
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
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="masterDropdown">
                                    <li><a class="dropdown-item" href="{{ url('/users') }}">Pengguna</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/konselors') }}">Konselor</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/jadwals') }}">Jadwal</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/appointments') }}">Sesi</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/feedback') }}">Feedback</a></li>
                                </ul>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }})
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
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

    {{-- Konten Utama --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
