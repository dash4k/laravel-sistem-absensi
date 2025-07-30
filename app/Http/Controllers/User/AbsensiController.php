<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shift = Shift::where('user_id', Auth::id())->where('date', now()->toDateString())->first();

        if (!$shift) {
            return redirect()->route('shift.index')->with('error', 'Anda belum membuat shift untuk hari ini.');
        }
        
        $absensi = Absensi::where('shift_id', $shift->id)->latest()->first();
        return view('user.absensi', compact('absensi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $now = now()->toDateString();

        $shift = Shift::where('user_id', $user->id)->where('date', $now)->first();
        if (!$shift) {
            return redirect()->back()->with('error', 'Shift Anda untuk hari ini belum terdaftar!');
        }

        $request->validate([
            'lokasi' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'status' => 'required|in:on_duty,off_duty,istirahat',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $buktiPath = $request->file('bukti')->store('bukti_absensi', 'public');

        Absensi::create([
            'shift_id' => $shift->id,
            'time' => now()->format('H:i:s'),
            'bukti' => $buktiPath,
            'status' => $request->input('status'),
            'lokasi' => $request->input('lokasi'),
            'keterangan' => $request->input('keterangan'),
            'latitude' => $request->input('latitude'),
            'longitude' => $request->input('longitude'),
        ]);

        if ($request->input('status') === 'off_duty') {
            $shift->end_time = now()->format('H:i:s');
            $shift->save();
        }

        return redirect()->route('absensi.index')->with('success', 'Absensi berhasil disimpan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
