<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyContext;
use App\Models\SurveyQuestion;
use Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;


class SurveyController extends Controller
{
    public function index(){
        return view('pages.index');
    }

    public function show(Request $req){
        // $surveys = Survey::where('status', '!=', 'draft')
        //                 ->where('status', '!=', 'archived')->orderBy('created_at','desc')->paginate(9);
        // return view('pages.survey-show-all', ['surveys'=>$surveys]);

        $search = request('search');
         $sort = $req->input('sort', 'newest');

        $contexts = SurveyContext::with('tags')
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('tags', function ($tagQuery) use ($search) {
                        $tagQuery->where('name', 'like', "%{$search}%");
                    });

                });

            })        ->when($sort === 'newest', function ($query) {
            $query->orderBy('created_at', 'desc');
        })
        ->when($sort === 'oldest', function ($query) {
            $query->orderBy('created_at', 'asc');
        })
        ->when($sort === 'name', function ($query) {
            $query->orderBy('title', 'asc');
        })
        ->paginate(9);

        return view('pages.survey-show-all', ['contexts' => $contexts->appends(request()->query())]);
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

    public function showCreate($context_id){
        return view('pages.survey-create', ['context_id' => $context_id]);
    }

    public function create(Request $req, $context_id){
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
            'context_id' => $context_id
        ]);

        foreach($validated['questions'] as &$question){
            unset($question['range']);
            $question['survey_id'] = $survey->id;
            SurveyQuestion::create($question);
        }


        return redirect()->route('survey.view.my');
    }

    public function viewMy(){
        $contexts = SurveyContext::where('user_id', auth()->id())->with(['surveys.questions', 'surveys.responses'])->orderBy('created_at', 'desc')->get();
        return view('pages.survey-show-my-all', ['contexts' => $contexts]);
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
        if($survey['user_id'] != auth()->id())abort(HttpResponse::HTTP_UNAUTHORIZED);
        return view('pages.survey-edit', ['survey' => $survey]);
    }

    public function update(Request $req, $id){
        $survey = Survey::findOrFail($id);
        if($survey['user_id'] != auth()->id())abort(HttpResponse::HTTP_UNAUTHORIZED);

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

        $survey = Survey::findOrFail($id);
        if($survey['user_id'] != auth()->id())abort(HttpResponse::HTTP_UNAUTHORIZED);

        SurveyQuestion::where(['survey_id' => $survey->id])->delete();

        foreach($validated['questions'] as &$question){
            unset($question['range']);
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
