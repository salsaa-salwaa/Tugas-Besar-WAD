<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\Authenticatable; // Impor Authenticatable interface

class AuthViewsController extends Controller
{
    /**
     * Menampilkan tampilan login.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Menampilkan tampilan registrasi.
     */
    public function showRegisterForm(): View
    {
        return view('auth.register');
    }

    /**
     * Mengimplementasikan proses login.
     */
    public function login(Request $request): RedirectResponse
    {
        // DEBUG: Cek apakah metode login diakses
        // dd('Metode login diakses.'); // Jangan aktifkan ini dulu, fokus pada register

        // Validasi input login
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // DEBUG: Cek kredensial yang diterima
        // dd('Kredensial yang diterima untuk login:', $credentials); // Aktifkan ini setelah register berhasil

        $authenticated = false;

        // Coba login berdasarkan username
        if (Auth::attempt(['username' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $authenticated = true;
        }

        // Jika login dengan username gagal, coba dengan email
        if (!$authenticated && Auth::attempt(['email' => $credentials['username'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $authenticated = true;
        }

        // DEBUG: Cek apakah autentikasi berhasil
        // dd('Status autentikasi setelah attempt:', $authenticated, 'User yang terotentikasi:', Auth::user()); // Aktifkan ini setelah register berhasil

        if ($authenticated) {
            $request->session()->regenerate();
            return $this->redirectBasedOnRole(Auth::user());
        }

        return back()->withErrors([
            'username' => 'Kredensial yang diberikan tidak cocok dengan catatan kami. Silakan coba lagi.',
        ])->onlyInput('username');
    }

    /**
     * Mengimplementasikan proses registrasi.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): RedirectResponse
    {
        // DEBUG: SANGAT PENTING - Cek apakah metode register diakses sama sekali
        // dd('Metode register diakses. Request data:', $request->all()); // Biarkan ini mati

        try {
            // 1. Validasi input
            $request->validate([
                'nama' => ['required', 'string', 'max:255'],
                'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
                'password' => ['required', 'confirmed', 'min:8'],
            ]);

            // DEBUG: Cek apakah validasi berhasil dan data siap dibuat
            // dd('Validasi registrasi berhasil. Data yang akan dibuat:', $request->all());


            // 2. Buat pengguna baru
            $user = User::create([
                'nama' => $request->nama,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'mahasiswa', // Secara default, setiap pendaftar baru adalah 'mahasiswa'
            ]);

            // DEBUG: Cek apakah objek user berhasil dibuat
            dd('User berhasil dibuat di database:', $user); // AKTIFKAN DEBUG INI SEKARANG

            // 3. Trigger event Registered (opsional, tapi bagus untuk konsistensi)
            event(new Registered($user));

            // 4. Login pengguna setelah registrasi berhasil
            Auth::login($user);

            // 5. Redirect ke dashboard atau halaman yang sesuai
            return $this->redirectBasedOnRole(Auth::user());

        } catch (ValidationException $e) {
            // DEBUG: Jika ada error validasi, tampilkan error
            // dd('Error Validasi Registrasi:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            // DEBUG: Tangani error lain yang mungkin terjadi saat menyimpan ke database
            dd('Terjadi error umum saat registrasi:', $e->getMessage(), $e->getTrace()); // AKTIFKAN DEBUG INI
            return back()->withErrors(['general' => 'Terjadi kesalahan saat registrasi. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Mengarahkan pengguna berdasarkan perannya.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     */
    protected function redirectBasedOnRole(Authenticatable $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Menghancurkan sesi autentikasi (logout).
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
