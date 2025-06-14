<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Aplikasi Konselor</title>
    <!-- Memuat Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f2f5;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <nav class="bg-blue-600 p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-bold rounded-md px-3 py-2 hover:bg-blue-700 transition duration-150 ease-in-out">Konselor App</a>
            <div>
                @auth
                    <span class="mr-4">Halo, {{ Auth::user()->nama }} ({{ Auth::user()->role }})!</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out mr-2">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-md shadow-md transition duration-150 ease-in-out">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-4xl font-bold text-gray-800 mb-6 text-center">
            Selamat Datang di Dashboard
            @if(isset($user_role))
                @if($user_role === 'mahasiswa')
                    Mahasiswa
                @elseif($user_role === 'admin')
                    Admin
                @endif
            @else
                Pengguna
            @endif
        </h1>

        <div class="text-center text-lg text-gray-600">
            <p>Ini adalah halaman dashboard Anda. Anda bisa menambahkan konten khusus di sini sesuai dengan peran Anda.</p>
            @auth
                @if(Auth::user()->role === 'mahasiswa')
                    <p class="mt-4">Sebagai Mahasiswa, Anda dapat:</p>
                    <ul class="list-disc list-inside mt-2 text-left inline-block">
                        <li><a href="{{ route('appointments.index') }}" class="text-blue-600 hover:underline">Melihat Jadwal Janji Temu</a></li>
                        <li><a href="{{ route('appointments.create') }}" class="text-blue-600 hover:underline">Membuat Janji Temu Baru</a></li>
                        <li><a href="{{ route('feedback.index') }}" class="text-blue-600 hover:underline">Memberikan Feedback</a></li>
                    </ul>
                @elseif(Auth::user()->role === 'admin')
                    <p class="mt-4">Sebagai Admin, Anda memiliki akses ke:</p>
                    <ul class="list-disc list-inside mt-2 text-left inline-block">
                        <li><a href="{{ route('konselors.index') }}" class="text-blue-600 hover:underline">Manajemen Konselor</a></li>
                        <li><a href="{{ route('jadwals.index') }}" class="text-blue-600 hover:underline">Manajemen Jadwal Konseling</a></li>
                        <li><a href="{{ route('users.index') }}" class="text-blue-600 hover:underline">Manajemen Pengguna</a></li>
                    </ul>
                @endif
            @endauth
        </div>
    </div>
</body>
</html>
