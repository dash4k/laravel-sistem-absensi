<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shift = Shift::where('user_id', Auth::id())->where('date', now()->toDateString())->first();
        return view('user.shift', compact('shift'));
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
        $now = now();

        if (Shift::where('user_id', $user->id)->where('date', $now)->exists()) {
            return redirect()->back()->with('error', 'Shift Anda untuk hari ini telah terdaftar!');
        }

        $request->validate([
            'shift_type' => 'required|in:pagi,sore,izin',
        ]);

        if ($request->input('shift_type') === 'izin') {
            if ($request->hasFile('bukti') && $request->input('keterangan')) {
                $request->validate([
                    'bukti' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                    'keterangan' => 'required|string|max:255',
                ]);

                $buktiPath = $request->file('bukti')->store('bukti_izin', 'public');
                Shift::create([
                    'user_id' => $user->id,
                    'date' => $now,
                    'shift_type' => $request->input('shift_type'),
                    'start_time' => now()->format('H:i:s'),
                    'end_time' => null,
                    'keterangan' => $request->input('keterangan'),
                    'bukti' => $buktiPath,
                ]);
            }
            else {
                return redirect()->back()->with('error', 'Bukti dan keterangan harus diisi untuk izin!');
            }
        } else {
            Shift::create([
                'user_id' => $user->id,
                'date' => $now,
                'shift_type' => $request->input('shift_type'),
                'start_time' => now()->format('H:i:s'),
            ]);
        }

        return redirect()->back()->with('success', 'Shift berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $shift = Shift::with('user', 'absensis')->findOrFail($id);
        $absensis = $shift->absensis;

        return view('user.absensi-recap', compact('shift', 'absensis'));
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

    public function shiftList()
    {
        $shifts = Shift::where('user_id', Auth::id())->get();
        $todaysShift = Shift::where('user_id', Auth::id())->whereDate('date', today())->first();

        return view('user.shift-recap', compact('shifts', 'todaysShift'));
    }
}
