<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'photo',
        'province',
        'province_code',
        'city',
        'city_code',
        'phone',
        'postal_code',
        'detail_address',
        'gender'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
