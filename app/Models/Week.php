<?php

namespace App\Models;

use App\Models\Time;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];

    public function times()
    {
        return $this->hasMany(Time::class);
    }
}
