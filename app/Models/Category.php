<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Categorypricing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'cat_id',
        'price',
        'image',
        'time'
    ];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'cat_id');
    }

    public function categoryPricings()
    {
        return $this->hasMany(Categorypricing::class, 'cat_id');
    }
}
