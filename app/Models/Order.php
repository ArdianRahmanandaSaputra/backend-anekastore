<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'status',
        'total',
        'status_pembayaran',
        'snap_token'
    ];

    public $incrementing = false;

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->id = Uuid::uuid4()->toString();
        });
    }

    public function orderdetails(){
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function shipment(){
        return $this->hasOne(Shipment::class, 'order_id', 'id');
    }
}
