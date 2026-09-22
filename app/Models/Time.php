<?php

namespace App\Models;

use App\Models\Week;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    use HasFactory;

    protected $fillable = [
        'start',
        'end',
        'week_id'
    ];

    public function week()
    {
        return $this->belongsTo(Week::class);
    }
}
