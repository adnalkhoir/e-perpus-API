<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class books extends Model
{
    use HasFactory;

    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'publisher',
        'publication_year',
        'isbn',
        'stock',
        'cover_image',
        'description',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(categories::class);
    }

    public function borrowings()
    {
        return $this->hasMany(borrowings::class);
    }
}
