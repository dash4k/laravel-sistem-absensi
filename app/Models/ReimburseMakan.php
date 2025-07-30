<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReimburseMakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'shift_id',
        'nominal',
        'nota',
        'bukti',
        'keterangan',
        'status',
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'id');
    }
}
