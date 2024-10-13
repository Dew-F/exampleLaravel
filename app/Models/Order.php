<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'manager_id',
        'order_status',
        'pay_status',
        'price_uid',
        'full_name',
        'telephone',
        'email',
        'total',
        'created_at'
    ];

    public function manager() {
        return $this->belongsTo(Manager::class, 'manager_id');
    }

    protected $casts = [
        'created_at' => 'datetime'
    ];
}
