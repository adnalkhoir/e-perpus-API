<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class fines extends Model
{
    use HasFactory;

    protected $table = 'fines';

    protected $fillable = [
        'user_id',
        'borrowing_id',
        'amount',
        'paid_at',
    ];

    public function borrowing()
    {
        return $this->belongsTo(borrowings::class, 'borrowing_id');
    }
}
