<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'name',
        'status',
        'ip_address',
        'api_key',
        'owner_name',
        'owner_mobile'
    ];

    protected $guarded = ['id'];
}
