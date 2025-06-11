<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Konselor;
use Illuminate\Http\Request;
use Carbon\Carbon; 

class JadwalController extends Controller
{
    public function index()
    {
        
        $jadwals = Jadwal::with('konselor')->get(); 
        return view('jadwals.index', compact('jadwals'));
    }

    public function create()
    {
        $konselors = Konselor::all(); 

        return view('jadwals.create', compact('konselors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'konselor_id' => 'required|exists:konselors,id_konselor', 
            'waktu' => 'required|array', 
            'waktu.*' => 'date_format:H:i', 
        ]);

        if (count($request->hari) != count($request->waktu)) {
            return back()->withErrors(['error' => 'Jumlah hari dan waktu harus sama']);
        }

        foreach ($request->hari as $index => $day) {
            $startTime = Carbon::createFromFormat('H:i', $request->waktu[$index]);
            $endTime = $startTime->copy()->addHour(); 

            Jadwal::create([
                'konselor_id' => $request->konselor_id,
                'hari' => $day,
                'waktu' => $request->waktu[$index],  
                'waktu_selesai' => $endTime->format('H:i'), 
            ]);
        }

        return redirect()->route('jadwals.index');
    }

    public function edit(Jadwal $jadwal)
    {
        $konselors = Konselor::all();

        $selected_days = explode(',', $jadwal->hari);
        $selected_times = explode(',', $jadwal->waktu);

        return view('jadwals.edit', compact('jadwal', 'konselors', 'selected_days', 'selected_times'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'konselor_id' => 'required|exists:konselors,id_konselor',
            'hari' => 'required|array', 
            'waktu' => 'required|array', 
            'waktu.*' => 'date_format:H:i', 
        ]);

        if (count($request->hari) != count($request->waktu)) {
            return back()->withErrors(['error' => 'Jumlah hari dan waktu harus sama']);
        }

        $jadwal->delete();

        foreach ($request->hari as $index => $day) {
            $startTime = Carbon::createFromFormat('H:i', $request->waktu[$index]);
            $endTime = $startTime->copy()->addHour(); 

            Jadwal::create([
                'konselor_id' => $request->konselor_id,
                'hari' => $day,
                'waktu' => $request->waktu[$index],  
                'waktu_selesai' => $endTime->format('H:i'), 
            ]);
        }

        return redirect()->route('jadwals.index');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();

        return redirect()->route('jadwals.index');
    }
}
