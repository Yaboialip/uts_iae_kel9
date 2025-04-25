<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id', 'customer_name', 'menu_id', 'menu_name', 'price'
    ];
    

    // Other model methods
}