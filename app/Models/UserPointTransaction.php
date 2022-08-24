<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPointTransaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'point_value', 'type','comment'
    ];
}
