<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'name',
        'description',
        'price',
        'image',
        'img_url',
    ];

   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    
    public function variants()
    {
        return $this->hasMany(Variant::class);
    }
}
