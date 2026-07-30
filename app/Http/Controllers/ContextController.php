<?php

namespace App\Http\Controllers;

use App\Models\ContextBlock;
use App\Models\SurveyContext;
use Illuminate\Http\Request;

class ContextController extends Controller
{
    public function view($id){
        $context = SurveyContext::find($id);
        return view('pages.context-view', ['context' => $context]);
    }

    public function showCreate(){
        return view('pages.context-create');
    }

    public function create(Request $req){

        $context = SurveyContext::create([
            'user_id' => auth()->id(),
            'title' => $req['title'],
            'preview' => $req['preview']
        ]);

        foreach($req['context'] as $index=>$block){
            $val = '';
            if($block['type'] == 'text'){
                $val = $block['value'];
            }
            else if($block['type'] == 'image'){
                $val = $block['value']->store('context_pictures', 'public');
            }

            ContextBlock::create([
                'context_id' => $context->id,
                'position' => ContextBlock::where('context_id',$context->id)->count(),
                'type' => $block['type'],
                'value' => $val,
            ]);
        }

        return redirect()->route('survey.create.show',['context_id' => $context->id]);
    }


}
