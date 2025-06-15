<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Konselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function index()
    {
        if (Auth::user()->role === 'admin') {
            $jadwals = Jadwal::with('konselor')->orderBy('hari')->orderBy('waktu')->get();
            return view('jadwals.index', compact('jadwals'));
        }
        
        $allJadwals = Jadwal::with('konselor')->orderBy('hari')->orderBy('waktu')->get();
        $jadwalsByKonselor = $allJadwals->groupBy('konselor_id');
        
        return view('jadwals.index', compact('jadwalsByKonselor'));
    }

    public function create()
    {
        $konselors = Konselor::all();
        return view('jadwals.create', compact('konselors'));
    }

    // --- PERBAIKAN UTAMA ADA DI FUNGSI STORE INI ---
    public function store(Request $request)
    {
        $request->validate([
            'konselor_id' => 'required|exists:konselors,id_konselor',
            'jadwal' => 'nullable|array', // Memvalidasi bahwa 'jadwal' adalah sebuah array
        ]);

        $jadwalData = $request->input('jadwal', []);
        $konselorId = $request->input('konselor_id');
        $createdCount = 0;

        // Loop melalui setiap hari yang dikirim dari form
        foreach ($jadwalData as $hari => $waktuArray) {
            // Pastikan ada waktu yang dipilih untuk hari tersebut
            if (!empty($waktuArray)) {
                // Loop melalui setiap waktu yang dipilih
                foreach ($waktuArray as $waktu) {
                    $startTime = Carbon::createFromFormat('H:i', $waktu);
                    $endTime = $startTime->copy()->addHour(); // Asumsi durasi sesi 1 jam

                    Jadwal::create([
                        'konselor_id' => $konselorId,
                        'hari' => $hari,
                        'waktu' => $waktu,
                        'waktu_selesai' => $endTime->format('H:i'),
                    ]);
                    $createdCount++;
                }
            }
        }
        
        // Jika tidak ada satupun jadwal yang dibuat, kembalikan dengan error
        if ($createdCount === 0) {
            return back()->withErrors(['jadwal' => 'Anda harus memilih setidaknya satu slot waktu.'])->withInput();
        }

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit(Jadwal $jadwal)
    {
        $konselors = Konselor::all();
        return view('jadwals.edit', compact('jadwal', 'konselors'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'konselor_id' => 'required|exists:konselors,id_konselor',
            'hari' => 'required|string',
            'waktu' => 'required|date_format:H:i',
        ]);

        $startTime = Carbon::createFromFormat('H:i', $request->waktu);
        $endTime = $startTime->copy()->addHour();

        $jadwal->update([
            'konselor_id' => $request->konselor_id,
            'hari' => $request->hari,
            'waktu' => $request->waktu,
            'waktu_selesai' => $endTime->format('H:i'),
        ]);

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
