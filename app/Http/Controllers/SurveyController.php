<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyQuestion;
use Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(){
        return view('pages.index');
    }

    public function show(){
        $surveys = Survey::where('status', '!=', 'draft')
                        ->where('status', '!=', 'archived')->get();
        return view('pages.survey-show-all', ['surveys'=>$surveys]);
    }


    public function view($id){
        $survey = Survey::find($id);
        $surveyQuestions = SurveyQuestion::where('survey_id', '=', $survey->id)->get();

        session([
            'start_time' => now()->toISOString()
        ]);

        return view('pages.survey-show', [
            'survey' => $survey,
            'surveyQuestions' => $surveyQuestions
        ]);
    }

    public function showCreate(){
        return view('pages.survey-create');
    }

    public function create(Request $req){
        $validated = $req->validate(
            [
                'title' => ['string','required','max:255'],
                'description' => ['string','max:255','nullable'],
                'questions' => ['array','required','min:1'],
                'questions.*.question' => ['string','required','max:255'],
                'questions.*.type' => ['required','in:text,choice,slider,select'],
                'questions.*.required' => ['sometimes'],
                'questions.*.private' => ['sometimes'],
                'questions.*.options' => ['nullable', 'array', 'min:1'],
                'questions.*.options.*' => ['string', 'required', 'max:255'],
                'questions.*.range' => ['nullable', 'array', 'min:2', 'max:2'],
                'questions.*.range.*' => ['integer', 'required']
            ]
        );
        foreach ($validated['questions'] as &$question) {
            if (!isset($question['required'])){
                    $question['required'] = false;
            }

            if(isset($question['options'])){
                $question['options'] = Arr::join($question['options'],'|');
            }

            if($question['type'] === 'slider'){
                $question['options'] = Arr::join($question['range'],'|');
            }else $question['range'] = null;
        }

        $validated['user_id'] = Auth::user()->id;

        $survey = Survey::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'user_id' => auth()->id(),
        ]);

        foreach($validated['questions'] as &$question){
            unset($question['range']);
            $question['survey_id'] = $survey->id;
            SurveyQuestion::create($question);
        }


        return redirect()->route('survey.view.my');
    }

    public function viewMy(){
        $surveys = Survey::where('user_id','=',auth()->id())->get();
        return view('pages.survey-show-my-all', ['surveys' => $surveys]);
    }

    public function changeStatus(Request $req, $id){
        $validated = $req->validate([
            'status' => ['in:draft,active,closed,archived']
        ]);

        $survey = Survey::find($id)->update([
            'status' => $validated['status']
        ]);

        return redirect()->route('survey.view.my');
    }

    public function showEdit($id){
        $survey = Survey::find($id);
        return view('pages.survey-edit', ['survey' => $survey]);
    }

    public function update(Request $req, $id){
        $validated = $req->validate(
            [
                'title' => ['string','required','max:255'],
                'description' => ['string','max:255','nullable'],
                'questions' => ['array','required','min:1'],
                'questions.*.question' => ['string','required','max:255'],
                'questions.*.type' => ['required','in:text,choice'],
                'questions.*.required' => ['sometimes'],
                'questions.*.options' => ['nullable', 'array', 'min:1'],
                'questions.*.options.*' => ['string', 'required', 'max:255']
            ]
        );
        foreach ($validated['questions'] as &$question) {
            if (!isset($question['required'])) {
                $question['required'] = false;
            }
        }

        foreach($validated['questions'] as &$question){
            if(isset($question['options'])){
                $question['options'] = Arr::join($question['options'],'|');
            }
        }

        $validated['user_id'] = Auth::user()->id;

        $survey = Survey::find($id);

        $survey->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        SurveyQuestion::where(['survey_id' => $survey->id])->delete();

        foreach($validated['questions'] as &$question){
            $question['survey_id'] = $survey->id;
            SurveyQuestion::create($question);
        }


        return redirect()->route('survey.view.my');
    }

    public function delete($id){
        Survey::find($id)->delete();

        return redirect()->route('survey.view.my');
    }
}
