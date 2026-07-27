<?php

namespace App\Http\Controllers;

use App\Models\Response;
use App\Models\Survey;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    public function create(Request $req, int $id){

        if(Survey::alreadyRespondedStatic($id) || Survey::where('id',$id)->where('user_id',auth()->id())->exists()){
            return abort(400, 'You are not allowed to respond to this survey');
        }

        $validated = $req->validate([
            'answers' => ['array','required'],
            'answers.*' => ['string', 'max:255']
        ]);

        $str = implode('|',$validated['answers']);


        Response::create([
            'user_id'=>auth()->id(),
            'survey_id'=>$id,
            'answers'=>$str
        ]);

        return redirect()->route('survey.home');
    }
}
