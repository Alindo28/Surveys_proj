<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ContextTag;

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



    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'context_tags',
            'context_id',
            'tag_id'
        );
    }
}
