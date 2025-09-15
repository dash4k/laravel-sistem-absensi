<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RekapanController extends Controller
{
    public function harian(Request $request)
    {
        $request->validate([
            'date' => 'nullable|date'
        ]);
        
        $now = $request->input('date') ? Carbon::parse($request->input('date')) : now();

        $users = User::where('role', '!=', 'admin')->get();
        $todayShifts = Shift::with('user')->whereDate('date', $now)->get();
        $shiftIds = $todayShifts->pluck('id');
        $todayAbsensis = Absensi::whereIn('shift_id', $shiftIds)->with('shift.user')->get();

        $onDuty = 0;
        $offDuty = 0;
        $istirahat = 0;
        $noAbsen = 0;
        $izin = 0;

        foreach ($users as $pegawai) {
            $shift = $todayShifts->firstWhere('user_id', $pegawai->id);
            $absensi = $todayAbsensis->where('shift_id', $shift->id ?? null)->last();

            if (!$shift) {
                $noAbsen++;
            } else {
                if ($shift->shift_type == 'izin') {
                    $izin++;
                } elseif($shift->shift_type != 'izin'&& !$absensi) {
                    $noAbsen++;
                } else {
                    switch ($absensi->status) {
                        case 'on_duty':
                            $onDuty++;
                            break;
                        case 'off_duty':
                            $offDuty++;
                            break;
                        case 'istirahat':
                            $istirahat++;
                            break;
                    }
                }
            }
        }

        $sortedUsers = $users->sortBy(function ($pegawai) use ($todayShifts, $todayAbsensis) {
            $shift = $todayShifts->firstWhere('user_id', $pegawai->id);
            $absensi = $todayAbsensis->where('shift_id', $shift->id ?? null)->last();

            // Assign priority number for each status
            if (!$shift || !$absensi) {
                return 3; // Belum Absen (lowest priority)
            }

            return match ($absensi->status) {
                'on_duty' => 0,
                'istirahat' => 1,
                'off_duty' => 2,
                default => 3,
            };
        });

        return view('admin.rekapan-harian', compact(
            'now',
            'sortedUsers',
            'todayShifts',
            'todayAbsensis',
            'onDuty',
            'offDuty',
            'istirahat',
            'noAbsen',
            'izin',
        ));
    }

    public function showAbsensi(string $id) 
    {
        $shift = Shift::findOrFail($id);
        $absensis = $shift->absensis;

        if ($shift->shift_type == 'izin') {
            return view('user.absensi-recap-izin', compact('shift', 'absensis'));
        }
        return view('user.absensi-recap', compact('shift', 'absensis'));
    }
}