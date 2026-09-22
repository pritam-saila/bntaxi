<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedPrice extends Model
{
    use HasFactory;

    protected $table = 'fixed_prices';

    protected $fillable = [
        'car_id',
        'destination_name',
        'drop_price',
        'pickup_price',
        'keywords'
    ];

    public function car()
    {
        return $this->belongsTo(Cars::class, 'car_id');
    }
}
