<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'seller_id',
        'cart_id',
        'total',
    ];

    public function historicals()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
