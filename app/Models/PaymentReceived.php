<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReceived extends Model
{
    use HasFactory;

    protected $table = 'payments_received';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['merchant', 'order_id', 'amount_paid', 'description', 'payment_id', 'date_paid', 'payer_id', 'method', 'payer_ip', 'hash', 'errors', 'date'];

    protected $casts = [
        'date' => 'datetime',
        'date_paid' => 'datetime'
    ];
}
