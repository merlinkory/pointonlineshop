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

    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
