<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

// app/Models/Menu.php

protected $fillable = ['name', 'description', 'price'];

}
