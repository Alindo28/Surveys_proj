<?php

namespace App\Http\Controllers;

use App\Models\ContextBlock;
use App\Models\SurveyContext;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

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

    public function showEdit($id){
        $context = SurveyContext::find($id);
        if($context->user_id != auth()->id())return abort(HttpResponse::HTTP_UNAUTHORIZED);
        return view('pages.context-edit', ['context' => $context]);
    }

    public function update(Request $req, $id){

        $context = SurveyContext::find($id);
        if($context->user_id != auth()->id())return abort(HttpResponse::HTTP_UNAUTHORIZED);

        ContextBlock::where('context_id',$id)->delete();

        foreach($req['context'] as $index=>$block){
            $val = '';
            if($block['type'] == 'text'){
                $val = $block['value'];
            }
            else if($block['type'] == 'image'){
                $val = isset($block['value']) ? $block['value']->store('context_pictures', 'public') : $block['prev_val'];
            }

            ContextBlock::create([
                'context_id' => $context->id,
                'position' => ContextBlock::where('context_id',$context->id)->count(),
                'type' => $block['type'],
                'value' => $val,
            ]);
        }

        return redirect()->route('survey.view.my');
    }

    public function delete($id){
        $context = SurveyContext::find($id);
        if($context->user_id != auth()->id())return abort(HttpResponse::HTTP_UNAUTHORIZED);

        $context->deleteOrFail();

        return redirect()->route('survey.view.my');
    }

}
