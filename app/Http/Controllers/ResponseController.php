<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use App\Models\Response;
use App\Models\Survey;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ResponseController extends Controller
{
    public function create(Request $req, int $id){
        if(Survey::alreadyRespondedStatic($id) || Survey::find($id)['status'] == 'closed' || Survey::where('id',$id)->where('user_id',auth()->id())->exists()){
            return abort(400, 'You are not allowed to respond to this survey');
        }

        $validated = $req->validate([
            'answers' => ['array','required'],
        ]);

        $start = Carbon::parse(session('start_time'));
        $dura = ceil($start->diffInSeconds(now()));

        session()->forget('start_time');

        Response::create([
            'user_id'=>auth()->id(),
            'survey_id'=>$id,
            'answers'=>$validated['answers'],
            'duration'=>$dura
        ]);

        return redirect()->route('survey.view',['id'=>$id]);
    }


    public function view($id){
        $survey = Survey::findOrFail($id);
        if($survey['user_id'] != auth()->id())abort(HttpResponse::HTTP_UNAUTHORIZED);

        $responses = Response::where('survey_id',$id)->get()->reverse();

        return(view('pages.responses-view', ['survey' => $survey, 'responses' => $responses]));
    }

    public function analysis($id)
    {
        $survey = Survey::with('questions')
            ->findOrFail($id);

        $responses = Response::where('survey_id', $id)->get();

        if($responses->count() <= 0)return redirect()->back();

        $avg_time = 0;
        foreach($responses as $r){
            $avg_time += $r['duration'];
        }
        $avg_time = ceil($avg_time/count($responses));

        $analysis = [];

        $ans_ind = 0;
        foreach ($survey->questions as $question) {

            $answers = $responses->map(function ($res) use($question){
                if(isset($res->answers[$question->id])){
                    return $res->answers[$question->id];
                }
            });

            if ($question->type === 'choice') {

                $counts = [];

                // Add all options with 0 votes
                foreach ($question->options as $option) {
                    $counts[$option] = 0;
                }

                // Count answers
                foreach ($answers as $answer) {
                    if (isset($counts[$answer])) {
                        $counts[$answer]++;
                    }
                }

                $percentages = [];

                foreach ($counts as $option => $count) {
                    $percentages[$option] = count($answers) > 0
                        ? round(($count / count($answers)) * 100, 1)
                        : 0;
                }

                $analysis[$question->id] = [
                    'question' => $question->question,
                    'type' => 'choice',
                    'total' => count($answers),
                    'results' => $percentages,
                    'private' => false
                ];
            }
            else if ($question->type === 'select') {

                $counts = [];

                foreach ($question->options as $option) {
                    $counts[$option] = 0;
                }

                foreach ($answers as $answer) {
                    foreach ($answer as $single_answer) {
                        if (isset($counts[$single_answer])) {
                            $counts[$single_answer]++;
                        }
                    }
                }

                $percentages = [];

                foreach ($counts as $option => $count) {
                    $percentages[$option] = round(
                        ($count / count($answers)) * 100,
                        1
                    );
                }

                if(!$question['private'] || $survey->user_id == auth()->id()){
                $analysis[$question->id] = [
                    'question' => $question->question,
                    'type' => 'select',
                    'total' => count($answers),
                    'results' => $percentages,
                    'private' => false
                ];}else{
                    $analysis[$question->id] = [
                    'question' => $question->question,
                    'private' => true
                    ];
                }

            }
            else if($question->type === 'text') {

                if(!$question['private'] || $survey->user_id == auth()->id()){
                $analysis[$question->id] = [
                    'question' => $question->question,
                    'type' => 'text',
                    'total' => count($answers),
                    'answers' => $answers,
                    'private' => false
                ];}else{
                    $analysis[$question->id] = [
                    'question' => $question->question,
                    'private' => true
                    ];
                }
            }
            else if($question->type === 'slider') {
                if(!$question['private'] || $survey->user_id == auth()->id()){
                $analysis[$question->id] = [
                    'question' => $question->question,
                    'type' => 'slider',
                    'options' => $question->options,
                    'total' => count($answers),
                    'answers' => $answers,
                    'private' => false
                ];}else{
                    $analysis[$question->id] = [
                    'question' => $question->question,
                    'private' => true
                    ];
                }
            }

            $ans_ind++;
        }


        return view('pages.responses-analysis', [
            'survey' => $survey,
            'responses' => $responses,
            'analysis' => $analysis,
            'avg_time' => CarbonInterval::seconds($avg_time)->cascade()
        ]);
    }
}
