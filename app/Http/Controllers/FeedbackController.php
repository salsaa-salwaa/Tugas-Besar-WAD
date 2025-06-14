<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Konselor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /**
     * Tampilkan semua feedback.
     */
    public function index()
    {
        $feedbacks = Feedback::with(['mahasiswa', 'konselor'])->latest()->get();
        return view('feedback.index', compact('feedbacks'));
    }

    /**
     * Tampilkan form untuk mengisi feedback.
     */
    public function create()
    {
        $konselors = Konselor::all();
        return view('feedback.create', compact('konselors'));
    }

    /**
     * Simpan feedback baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'konselor_id' => 'required|exists:konselors,id_konselor',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        Feedback::create([
            'mahasiswa_id' => Auth::user()->id_user,
            'konselor_id' => $request->konselor_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->route('feedback.create')->with('success', 'Feedback berhasil dikirim!');
    }

    /**
     * Hapus feedback.
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return redirect()->route('feedback.index')->with('success', 'Feedback berhasil dihapus.');
    }
}
