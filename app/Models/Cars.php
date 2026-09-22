<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'minprice',
        'airport_surcharge',
        'image',
        'call_for_quote',
        'mileage_multiplier',
        'sort_order'
    ];

    public function books()
    {
        return $this->hasMany(Book::class, 'car');
    }

    public function distances()
    {
        return $this->hasMany(Distances::class, 'car_id');
    }

    public function fixedPrices()
    {
        return $this->hasMany(FixedPrice::class, 'car_id');
    }
}
