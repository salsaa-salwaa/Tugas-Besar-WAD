<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel App</title>
    {{-- Bootstrap CSS CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Laravel App</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    {{-- Menu Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active fw-semibold text-warning' : '' }}" href="{{ url('/dashboard') }}">Dashboard</a>
                    </li>

                    {{-- Dropdown Data Master --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->is('users') || request()->is('konselors') || request()->is('jadwals') || request()->is('sesis') ? 'active fw-semibold text-warning' : '' }}"
                           href="#" id="masterDropdown" role="button" data-bs-toggle="dropdown">
                            Data Master
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="masterDropdown">
                            <li><a class="dropdown-item" href="{{ url('/users') }}">Pengguna</a></li>
                            <li><a class="dropdown-item" href="{{ url('/konselors') }}">Konselor</a></li>
                            <li><a class="dropdown-item" href="{{ url('/jadwals') }}">Jadwal</a></li>
                            <li><a class="dropdown-item" href="{{ url('/sesis') }}">Sesi</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Konten Utama --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Bootstrap JS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
