    <?php

    use App\Http\Controllers\ProfileController;
    use App\Http\Controllers\AppointmentController;
    use App\Http\Controllers\KonselorController;
    use App\Http\Controllers\JadwalController;
    use App\Http\Controllers\FeedbackController;
    use App\Http\Controllers\UserController;
    use App\Http\Controllers\AuthViewsController;
    use Illuminate\Support\Facades\Route;
    use Illuminate\Support\Facades\Auth; // Tambahkan ini jika belum ada

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute ini
    | dimuat oleh RouteServiceProvider dalam grup yang berisi grup middleware "web".
    | Sekarang buat sesuatu yang hebat!
    |
    */

    Route::get('/', function () {
        return view('welcome');
    });

    // Rute untuk menampilkan tampilan login dan register
    // GET untuk menampilkan form
    Route::get('/login', [AuthViewsController::class, 'showLoginForm'])->name('login');
    Route::get('/register', [AuthViewsController::class, 'showRegisterForm'])->name('register');

    // POST untuk memproses form
    Route::post('/login', [AuthViewsController::class, 'login']);
    Route::post('/register', [AuthViewsController::class, 'register']);

    // Rute Logout
    Route::post('/logout', [AuthViewsController::class, 'logout'])->name('logout');


    // Rute dashboard default (bisa diakses setelah login, akan diarahkan nanti)
    Route::get('/dashboard', function () {
        // Ini akan menjadi halaman dashboard setelah login, yang mungkin perlu logika pengalihan peran
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif (Auth::user()->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }
        }
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard'); // Tetap lindungi dengan auth dan verified

    // Rute untuk Mahasiswa
    Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
        Route::get('/mahasiswa/dashboard', function () {
            return view('dashboard', ['user_role' => 'mahasiswa']);
        })->name('mahasiswa.dashboard');

        Route::resource('appointments', AppointmentController::class);
        Route::resource('feedback', FeedbackController::class);
    });

    // Rute untuk Admin
    Route::middleware(['auth', 'role:admin'])->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard', ['user_role' => 'admin']);
        })->name('admin.dashboard');

        Route::resource('konselors', KonselorController::class);
        Route::resource('jadwals', JadwalController::class);
        Route::resource('users', UserController::class);
    });

    // Rute Profil (bisa diakses oleh semua peran yang terotentikasi)
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    // Pastikan baris ini DIKOMENTARI atau DIHAPUS jika Anda menggunakan autentikasi kustom
    // require __DIR__.'/auth.php';

    