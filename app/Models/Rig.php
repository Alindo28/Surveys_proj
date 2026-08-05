<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rig extends Model
{
    protected $guarded = [];
        protected $casts = [
        'value' => 'array',
    ];
    public $timestamps = false;
}
