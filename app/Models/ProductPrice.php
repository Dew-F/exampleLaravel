<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'product_uid',
        'price_uid',
        'price',
    ];
}
