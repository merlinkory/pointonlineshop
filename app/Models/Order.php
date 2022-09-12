<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;
class Order extends Model
{
    use HasFactory;

    protected $fillable  = [
       'user_id', 'first_name','last_name','middle_name','city','address','zip'
    ];

    protected $appends = ['order_total'];

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }

    public function getOrderTotalAttribute(): float{

        return $this->orderItems->sum(function($item){
            return $item['quantity'] * $item['price'];
        });

    }
}
