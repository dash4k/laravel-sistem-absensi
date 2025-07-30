<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ReimburseBensin;
use App\Models\ReimburseBarang;
use App\Models\ReimburseMakan;
use App\Models\Shift;
use Illuminate\Support\Facades\Auth;

class ReimburseHistoryTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind'; // or 'tailwind'
    
    public int $page = 1;

    public function render()
    {
        $userId = Auth::id();
        $shiftIds = Shift::where('user_id', $userId)->pluck('id');

        $bensins = ReimburseBensin::whereIn('shift_id', $shiftIds)
            ->whereDate('created_at', '<', today())
            ->get()->map(fn($r) => $r->setAttribute('type', 'bensin'));

        $makans = ReimburseMakan::whereIn('shift_id', $shiftIds)
            ->whereDate('created_at', '<', today())
            ->get()->map(fn($r) => $r->setAttribute('type', 'makan'));

        $barangs = ReimburseBarang::whereIn('shift_id', $shiftIds)
            ->whereDate('created_at', '<', today())
            ->get()->map(fn($r) => $r->setAttribute('type', 'barang'));

        $merged = $bensins->merge($makans)->merge($barangs)
            ->sortByDesc('created_at')
            ->values();

        // Manual pagination
        $perPage = 10;
        $page = $this->page;
        $sliced = $merged->forPage($page, $perPage);

        return view('livewire.reimburse-history-table', [
            'reimbursements' => new \Illuminate\Pagination\LengthAwarePaginator(
                $sliced,
                $merged->count(),
                $perPage,
                $page,
                ['path' => request()->url(), 'query' => request()->query()]
            )
        ]);
    }
}
