<?php

namespace App\Http\Controllers;

use App\Models\Rig;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;

class RigController extends Controller
{
    public function access(Request $req, $id){
        if(auth()->user()->subscription == 'ultra' && $req['access_permisson'] == "granted"){
            session([
                'can_access_rig' => true,
                'can_access_rig_expires' => now()->addMinutes(3)
            ]);
            return redirect()->route('rig.enter', ['id' => $id]);
        }
        else return redirect()->back();
    }

    public function enter($id){
        if(!session('can_access_rig') || now()->greaterThan(session('can_access_rig_expires'))){
            abort(404);
        }

        $surveyQuestion = SurveyQuestion::find($id);
        $survey = $surveyQuestion->survey;

        if($survey['user_id'] != auth()->user()->id){
            abort(404);
        }

        return view('pages.rig', [
            'surveyQuestion' => $surveyQuestion,
            'Rigs' => Rig::where(['question_id' => $surveyQuestion['id']])->get(),
            'survey' => $survey
        ]);
    }

    public function create(Request $req, $id){
        if(auth()->user()->subscription != 'ultra')abort(404);

        $validated = $req->validate([
            'units' => ['integer', 'min:1', 'max:100'],
            'answers' => ['required']

        ]);

        if(SurveyQuestion::findOrFail($id)->survey->user->id != auth()->id()){
            abort(404);
        }

        Rig::create([
            'question_id' => $id,
            'value' => $validated['answers'],
            'units' => $validated['units'],
            'enable' => $req->boolean('enable'),
            'user_id' => auth()->id()
        ]);

        session([
            'can_access_rig' => true,
            'can_access_rig_expires' => now()->addMinutes(3)
        ]);
        return redirect()->back();
    }

    public function delete($id){
        Rig::find($id)->delete();

        session([
            'can_access_rig' => true,
            'can_access_rig_expires' => now()->addMinutes(3)
        ]);
        return redirect()->back();
    }

    public function toggle(Request $req, $id){

        Rig::where('question_id', $id)->update([
            'enable' => $req->boolean('toggle')
        ]);

        return response()->json([
            'success' => true
        ]);
    }

}
