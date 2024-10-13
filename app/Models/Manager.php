<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Manager extends Model
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'mail',
        'phone',
        'telegram_id',
        'display',
        'active',
        'is_admin'
    ];

    protected $guarded = [
        'id'
    ];
}
