<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContextBlock extends Model
{
    use HasFactory;
    protected $guarded = [];
    public $timestamps = false;
    public function context(){
        return $this->belongsTo(SurveyContext::class);
    }
}
