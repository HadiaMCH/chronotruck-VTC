<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_wilaya extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'wilaya_wilaya_id',
    ];
}
