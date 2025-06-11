<?php

namespace App\Http\Controllers;

use App\Models\Konselor;
use Illuminate\Http\Request;

class KonselorController extends Controller
{
    public function index()
    {
        $konselors = Konselor::all();
        return view('konselors.index', compact('konselors'));
    }

    public function create()
    {
        return view('konselors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'keahlian' => 'required|array',
            'keahlian.*' => 'in:akademik,karir,kecemasan,emosi,griefing,self-development', 
        ]);

        Konselor::create([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'keahlian' => json_encode($request->keahlian), 
        ]);

        return redirect()->route('konselors.index');
    }

    public function edit(Konselor $konselor)
    {
        return view('konselors.edit', compact('konselor'));
    }

    public function update(Request $request, Konselor $konselor)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:255',
            'keahlian' => 'required|array', 
            'keahlian.*' => 'in:akademik,karir,kecemasan,emosi,griefing,self-development', 
        ]);

        $konselor->update([
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'keahlian' => json_encode($request->keahlian),
        ]);

        return redirect()->route('konselors.index');
    }

    public function destroy(Konselor $konselor)
    {
        $konselor->delete();
        return redirect()->route('konselors.index');
    }
}
