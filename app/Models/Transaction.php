<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['order_id', 'amount_invoiced', 'amount_paid', 'description', 'payment_id', 'date_invoiced', 'date_paid', 'payer_id', 'method', 'payer_ip', 'hash'];

    protected $casts = [
        'date_invoiced' => 'datetime',
        'date_paid' => 'datetime'
    ];
}
