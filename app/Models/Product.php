<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'categori_id',
        'name',
        'photo',
        'price',
        'weight',
        'stock',
        'description'
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'categori_id');
    }

    public function discounts(){
        return $this->hasMany(Discount::class, 'product_id');
    }
}
