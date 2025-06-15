<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // TAMPILKAN KE VIEW, BUKAN JSON
    public function index()
    {
        $query = Appointment::with(['jadwal.konselor', 'mahasiswa'])->latest();

        if (Auth::user()->role === 'mahasiswa') {
            $query->where('mahasiswa_id', Auth::user()->id_user);
        }

        $appointments = $query->get();

        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        // Hindari jadwal yang sudah dibooking oleh user
        $booked = Appointment::where('mahasiswa_id', Auth::user()->id_user)->pluck('jadwal_id');

        $jadwals = Jadwal::with('konselor')
            ->whereNotIn('id_jadwal', $booked)
            ->orderBy('hari')
            ->orderBy('waktu')
            ->get();

        return view('appointments.create', compact('jadwals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id_jadwal',
            'tanggal' => 'required|date|after_or_equal:today',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:daring,luring',
        ]);

        // 1. Cek apakah user ini sudah pernah booking slot itu di tanggal itu
        $userAlreadyBooked = Appointment::where('mahasiswa_id', Auth::user()->id_user)
            ->where('jadwal_id', $request->jadwal_id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($userAlreadyBooked) {
            return back()->with('error', 'Kamu sudah pernah booking slot ini di tanggal tersebut.');
        }

        // 2. Cek apakah slot ini sudah dibooking siapapun di tanggal itu
        $slotTaken = Appointment::where('jadwal_id', $request->jadwal_id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($slotTaken) {
            return back()->with('error', 'Slot ini sudah dibooking orang lain di tanggal tersebut.');
        }

        Appointment::create([
            'mahasiswa_id' => Auth::user()->id_user,
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
            'status' => 'pending',
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment berhasil diajukan.');
    }

    public function edit($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (Auth::user()->role === 'mahasiswa' && Auth::user()->id_user !== $appointment->mahasiswa_id) {
            abort(403);
        }

        $jadwals = Jadwal::with('konselor')->get();

        return view('appointments.edit', compact('appointment', 'jadwals'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id_jadwal',
            'tanggal' => 'required|date|after_or_equal:today',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:daring,luring',
        ]);

        $appointment = Appointment::findOrFail($id);

        if (Auth::user()->role === 'mahasiswa' && Auth::user()->id_user !== $appointment->mahasiswa_id) {
            abort(403);
        }

        $appointment->update([
            'jadwal_id' => $request->jadwal_id,
            'tanggal' => $request->tanggal,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment berhasil diperbarui.');
    }

    public function acc(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:disetujui,ditolak']);

        $appointment = Appointment::findOrFail($id);
        $appointment->status = $request->status;
        $appointment->save();

        return back()->with('success', 'Status appointment diperbarui.');
    }

    public function cancel($id)
    {
        $appointment = Appointment::findOrFail($id);

        if (Auth::user()->id_user !== $appointment->mahasiswa_id) {
            abort(403);
        }

        if ($appointment->status !== 'pending') {
            return back()->with('error', 'Tidak bisa membatalkan appointment yang sudah diproses.');
        }

        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment berhasil dibatalkan.');
    }

    public function destroy($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->delete();

        return back()->with('success', 'Appointment dihapus.');
    }
}
