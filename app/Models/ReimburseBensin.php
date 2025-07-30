<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimburseBensin extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'kilometer',
        'nominal',
        'nota',
        'keterangan',
        'status',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }
}
