<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReimburseBarang;
use App\Models\ReimburseBensin;
use App\Models\ReimburseMakan;
use App\Models\Shift;
use App\Models\User;
use Illuminate\Http\Request;

class ReimburseController extends Controller
{
    public function index()
    {
        $makans = ReimburseMakan::with('shift.user')->get()
            ->map(function ($item) {
                $item->type = 'makan';
                $item->user_id = optional($item->shift)->user_id;
                return $item;
            });

        $bensins = ReimburseBensin::with('shift.user')->get()
            ->map(function ($item) {
                $item->type = 'bensin';
                $item->user_id = optional($item->shift)->user_id;
                return $item;
            });

        $barangs = ReimburseBarang::with('shift.user')->get()
            ->map(function ($item) {
                $item->type = 'barang';
                $item->user_id = optional($item->shift)->user_id;
                return $item;
            });

        $all = $makans->concat($bensins)->concat($barangs);

        $pendings = $all->where('status', false);
        
        $grouped = $all->groupBy('user_id');

        $usersTotals = $grouped->map(function ($items, $userId) {
            return [
                'user_id' => $userId,
                'user_name' => optional(optional($items->first()->shift)->user)->name,
                'lunas' => $items->where('status', true)->sum('nominal'),
                'pending' => $items->where('status', false)->sum('nominal'),
            ];
        });
        
        return view('admin.reimburse', compact('usersTotals', 'pendings'));
    }

    public function pegawaiPending($id)
    {
        $pegawai = User::findOrFail($id);

        $makans = ReimburseMakan::with('shift.user')->get()
            ->filter(function ($item) use ($id) {
                return optional($item->shift)->user_id == $id && $item->status == false;
            })->map(function ($item) {
                $item->type = 'makan';
                return $item;
            });

        $bensins = ReimburseBensin::with('shift.user')->get()
            ->filter(function ($item) use ($id) {
                return optional($item->shift)->user_id == $id && $item->status == false;
            })->map(function ($item) {
                $item->type = 'bensin';
                return $item;
            });

        $barangs = ReimburseBarang::with('shift.user')->get()
            ->filter(function ($item) use ($id) {
                return optional($item->shift)->user_id == $id && $item->status == false;
            })->map(function ($item) {
                $item->type = 'barang';
                return $item;
            });

        $pendings = $makans->concat($bensins)->concat($barangs);

        return view('admin.reimburse-pending', compact('pegawai', 'pendings'));
    }
    
    public function pegawaiLunas($id)
    {
        $pegawai = User::findOrFail($id);

        $makans = ReimburseMakan::with('shift.user')->get()
            ->filter(function ($item) use ($id) {
                return optional($item->shift)->user_id == $id && $item->status == true;
            })->map(function ($item) {
                $item->type = 'makan';
                return $item;
            });

        $bensins = ReimburseBensin::with('shift.user')->get()
            ->filter(function ($item) use ($id) {
                return optional($item->shift)->user_id == $id && $item->status == true;
            })->map(function ($item) {
                $item->type = 'bensin';
                return $item;
            });

        $barangs = ReimburseBarang::with('shift.user')->get()
            ->filter(function ($item) use ($id) {
                return optional($item->shift)->user_id == $id && $item->status == true;
            })->map(function ($item) {
                $item->type = 'barang';
                return $item;
            });

        $lunas = $makans->concat($bensins)->concat($barangs);

        return view('admin.reimburse-lunas', compact('pegawai', 'lunas'));
    }
    
    public function pegawaiTotal($id)
    {
        $pegawai = User::findOrFail($id);

        $shifts = Shift::where('user_id', $id)
                    ->orderBy('date')
                    ->paginate(5);

        foreach ($shifts as $shift) {
            $shift->makans = ReimburseMakan::where('shift_id', $shift->id)->get()->map(function ($item) {
                $item->type = 'makan';
                return $item;
            });

            $shift->bensins = ReimburseBensin::where('shift_id', $shift->id)->get()->map(function ($item) {
                $item->type = 'bensin';
                return $item;
            });

            $shift->barangs = ReimburseBarang::where('shift_id', $shift->id)->get()->map(function ($item) {
                $item->type = 'barang';
                return $item;
            });

            $shift->reimbursements = $shift->makans->concat($shift->bensins)->concat($shift->barangs);
        }

        return view('admin.reimburse-total', compact('pegawai', 'shifts'));
    }

    public function bensin($id)
    {
        $bensin = ReimburseBensin::with('shift.user')->findOrFail($id);

        return view('admin.reimburse-bensin', compact('bensin'));
    }

    public function bensinLunas($id)
    {
        $bensin = ReimburseBensin::findOrFail($id);

        if (!$bensin) {
            abort(404);
        }

        $bensin->status = true;
        $bensin->save();

        return redirect()->back()->with('success', 'Status reimburse berhasil diubah!');
    }
    
    public function makan($id)
    {
        $makan = ReimburseMakan::with('shift.user')->findOrFail($id);

        return view('admin.reimburse-makan', compact('makan'));
    }

    public function makanLunas($id)
    {
        $makan = ReimburseMakan::findOrFail($id);

        if (!$makan) {
            abort(404);
        }

        $makan->status = true;
        $makan->save();

        return redirect()->back()->with('success', 'Status reimburse berhasil diubah!');
    }

    public function barang($id)
    {
        $barang = ReimburseBarang::with('shift.user')->findOrFail($id);

        return view('admin.reimburse-barang', compact('barang'));
    }

    public function barangLunas($id)
    {
        $barang = ReimburseBarang::findOrFail($id);

        if (!$barang) {
            abort(404);
        }

        $barang->status = true;
        $barang->save();

        return redirect()->back()->with('success', 'Status reimburse berhasil diubah!');
    }
}
