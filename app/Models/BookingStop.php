<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingStop extends Model
{
    use HasFactory;

    protected $fillable = [
        'book_id',
        'address',
        'lat',
        'lng',
        'sequence',
        'notes',
    ];

    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
        'sequence' => 'integer',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
