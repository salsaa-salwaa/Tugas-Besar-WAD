<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with('mahasiswa', 'jadwal')->get(); 
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $jadwals = Jadwal::all();
        $mahasiswa = User::where('role', 'mahasiswa')->get(); 
        return view('appointments.create', compact('jadwals', 'mahasiswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id_user',
            'jadwal_id' => 'required|exists:jadwals,id_jadwal',
            'tipe' => 'required|in:daring,luring', 
        ]);

        Appointment::create([
            'mahasiswa_id' => $request->mahasiswa_id,
            'jadwal_id' => $request->jadwal_id,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('appointments.index');
    }

    public function edit(Appointment $appointment)
    {
        $jadwals = Jadwal::all();
        $mahasiswa = User::where('role', 'mahasiswa')->get(); 
        return view('appointments.edit', compact('appointment', 'jadwals', 'mahasiswa'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:users,id_user',
            'jadwal_id' => 'required|exists:jadwals,id_jadwal',
            'tipe' => 'required|in:daring,luring',
        ]);

        $appointment->update([
            'mahasiswa_id' => $request->mahasiswa_id,
            'jadwal_id' => $request->jadwal_id,
            'deskripsi' => $request->deskripsi,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('appointments.index');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index');
    }
}
