<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class borrowings extends Model
{
    use HasFactory;

    protected $table = 'borrowings';

    protected $fillable = [
        'user_id',
        'book_id',
        'borrow_date',
        'due_date',
        'return_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(books::class);
    }

    public function fine()
    {
        return $this->hasOne(fines::class, 'borrowing_id');
    }
}
