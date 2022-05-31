<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchasedProduct extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'purchased_products';
}
