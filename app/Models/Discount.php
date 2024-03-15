<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'constraint',
        'discounts',
        'description',
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}
