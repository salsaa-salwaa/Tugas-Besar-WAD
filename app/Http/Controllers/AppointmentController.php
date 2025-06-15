<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    public function index()
    {
        $query = Appointment::with(['mahasiswa', 'jadwal.konselor']);

        // Jika yang login adalah mahasiswa, hanya tampilkan data miliknya
        if (Auth::user()->role === 'mahasiswa') {
            $query->where('mahasiswa_id', Auth::id());
        }

        $appointments = $query->latest()->get();
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        // PERBAIKAN: Tidak perlu lagi mengirim daftar semua mahasiswa
        $jadwals = Jadwal::with('konselor')->get();
        return view('appointments.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            // Validasi mahasiswa_id tidak lagi dari form, tapi dari sesi
            'jadwal_id' => 'required|exists:jadwals,id_jadwal',
            'tipe' => 'required|in:daring,luring',
            'deskripsi' => 'nullable|string',
        ]);

        Appointment::create([
            // PERBAIKAN: Mengambil ID mahasiswa langsung dari pengguna yang sedang login
            'mahasiswa_id' => Auth::id(), 
            'jadwal_id' => $request->jadwal_id,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Sesi janji temu berhasil dibuat.');
    }

    public function edit(Appointment $appointment)
    {
        // Menambahkan keamanan: mahasiswa hanya bisa mengedit sesinya sendiri
        if (Auth::user()->role === 'mahasiswa' && $appointment->mahasiswa_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $jadwals = Jadwal::with('konselor')->get();
        // Tidak perlu mengirim daftar mahasiswa lagi
        return view('appointments.edit', compact('appointment', 'jadwals'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        // Menambahkan keamanan: mahasiswa hanya bisa mengedit sesinya sendiri
        if (Auth::user()->role === 'mahasiswa' && $appointment->mahasiswa_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id_jadwal',
            'tipe' => 'required|in:daring,luring',
            'deskripsi' => 'nullable|string',
        ]);
        
        // Admin bisa mengubah semua, mahasiswa tidak bisa mengubah pemilik sesi
        $dataToUpdate = $request->except('mahasiswa_id');

        $appointment->update($dataToUpdate);

        return redirect()->route('appointments.index')->with('success', 'Sesi berhasil diperbarui.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Sesi berhasil dihapus.');
    }
}
