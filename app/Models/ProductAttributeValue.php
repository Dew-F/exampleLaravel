<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'product_uid',
        'attribute_value_uid',
    ];

}
