<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }

    public function responses(){
        return $this->hasMany(Response::class);
    }

    public function context(){
        return $this->belongsTo(SurveyContext::class);
    }

    public function alreadyResponded():bool{
        if(Response::where('survey_id',$this->id)->where('user_id', auth()->id())->exists())return true;
        return false;
    }
    public static function alreadyRespondedStatic(int $survey_id):bool{
        if(Response::where('survey_id',$survey_id)->where('user_id', auth()->id())->exists())return true;
        return false;
    }

}
