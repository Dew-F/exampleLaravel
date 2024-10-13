<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['title', 'text', 'date', 'active', 'post_type_id'];

    protected $casts = [
        'date' => 'datetime'
    ];
}
