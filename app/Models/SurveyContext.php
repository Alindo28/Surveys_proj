<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyContext extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function surveys(){
        return $this->hasMany(Survey::class, 'context_id');
    }

    public function blocks(){
        return $this->hasMany(ContextBlock::class, 'context_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
