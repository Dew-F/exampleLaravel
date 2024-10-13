<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Custom extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['fullname', 'phone', 'email', 'text', 'date', 'manager_id', 'product_uid'];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_uid');
    }

    public function manager() {
        return $this->belongsTo(Manager::class, 'manager_id');
    }
}
