<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ReimburseBarang;
use App\Models\ReimburseBensin;
use App\Models\ReimburseMakan;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReimburseController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $todaysShift = Shift::where('user_id', $userId)
            ->whereDate('date', today())
            ->first();

        $todayReimbursements = collect();

        if ($todaysShift) {
            $todayReimbursements = collect()
                ->merge(ReimburseBensin::where('shift_id', $todaysShift->id)->get()->map(fn($r) => $r->setAttribute('type', 'bensin')))
                ->merge(ReimburseMakan::where('shift_id', $todaysShift->id)->get()->map(fn($r) => $r->setAttribute('type', 'makan')))
                ->merge(ReimburseBarang::where('shift_id', $todaysShift->id)->get()->map(fn($r) => $r->setAttribute('type', 'barang')));
        }

        $shiftIds = Shift::where('user_id', $userId)->pluck('id');

        $pendingTotal =
            ReimburseBensin::whereIn('shift_id', $shiftIds)->where('status', false)->sum('nominal') +
            ReimburseMakan::whereIn('shift_id', $shiftIds)->where('status', false)->sum('nominal') +
            ReimburseBarang::whereIn('shift_id', $shiftIds)->where('status', false)->sum('nominal');

        $completedTotal =
            ReimburseBensin::whereIn('shift_id', $shiftIds)->where('status', true)->sum('nominal') +
            ReimburseMakan::whereIn('shift_id', $shiftIds)->where('status', true)->sum('nominal') +
            ReimburseBarang::whereIn('shift_id', $shiftIds)->where('status', true)->sum('nominal');

        return view('user.reimburse', [
            'today' => $todayReimbursements,
            'pending' => $pendingTotal,
            'completed' => $completedTotal,
        ]);
    }

    public function create()
    {
        $shift = Shift::where('user_id', Auth::id())->where('date', now()->toDateString())->first();

        if (!$shift) {
            return redirect()->route('shift.index')->with('error', 'Anda belum membuat shift untuk hari ini.');
        }

        return view('user.reimburse-create');
    }

    public function bensin(Request $request)
    {
        $userId = Auth::id();

        $todaysShift = Shift::where('user_id', $userId)
            ->whereDate('date', today())
            ->first();

        if (!$todaysShift) {
            return redirect()->back()->with('error', 'Shift Anda untuk hari ini belum terdaftar!');
        }

        $request->validate([
            'kilometer' => 'required|numeric',
            'nominal' => 'required|numeric',
            'keterangan' => 'required|string',
            'nota' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $notaPath = $request->file('nota')->store('nota_bensin', 'public');

        ReimburseBensin::create([
            'shift_id' => $todaysShift->id,
            'kilometer' => $request->input('kilometer'),
            'nominal' => $request->input('nominal'),
            'keterangan' => $request->input('keterangan'),
            'nota' => $notaPath,
        ]);

        return redirect()->route('reimburse.user.index')->with('success', 'Reimburse bensin berhasil disimpan!');
    }

    public function makan(Request $request)
    {
        $userId = Auth::id();

        $todaysShift = Shift::where('user_id', $userId)
            ->whereDate('date', today())
            ->first();

        if (!$todaysShift) {
            return redirect()->back()->with('error', 'Shift Anda untuk hari ini belum terdaftar!');
        }

        $request->validate([
            'nominal' => 'required|numeric',
            'keterangan' => 'required|string',
            'nota' => 'required|image|mimes:jpeg,png,jpg|max:20480',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $notaPath = $request->file('nota')->store('nota_makan', 'public');
        $buktiPath = $request->file('bukti')->store('bukti_makan', 'public');

        ReimburseMakan::create([
            'shift_id' => $todaysShift->id,
            'nominal' => $request->input('nominal'),
            'keterangan' => $request->input('keterangan'),
            'nota' => $notaPath,
            'bukti' => $buktiPath,
        ]);

        return redirect()->route('reimburse.user.index')->with('success', 'Reimburse makan berhasil disimpan!');
    }
    
    public function barang(Request $request)
    {
        $userId = Auth::id();

        $todaysShift = Shift::where('user_id', $userId)
            ->whereDate('date', today())
            ->first();

        if (!$todaysShift) {
            return redirect()->back()->with('error', 'Shift Anda untuk hari ini belum terdaftar!');
        }

        $request->validate([
            'nominal' => 'required|numeric',
            'keterangan' => 'required|string',
            'nota' => 'required|image|mimes:jpeg,png,jpg|max:20480',
            'bukti' => 'required|image|mimes:jpeg,png,jpg|max:20480',
        ]);

        $notaPath = $request->file('nota')->store('nota_barang', 'public');
        $buktiPath = $request->file('bukti')->store('bukti_barang', 'public');

        ReimburseBarang::create([
            'shift_id' => $todaysShift->id,
            'nominal' => $request->input('nominal'),
            'keterangan' => $request->input('keterangan'),
            'nota' => $notaPath,
            'bukti' => $buktiPath,
        ]);

        return redirect()->route('reimburse.user.index')->with('success', 'Reimburse barang berhasil disimpan!');
    }
}
