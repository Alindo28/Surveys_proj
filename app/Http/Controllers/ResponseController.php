<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
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
            'answers.*' => ['string', 'max:255', 'nullable']
        ]);

        $str = implode('|',$validated['answers']);



        $start = Carbon::parse(session('start_time'));
        $dura = ceil($start->diffInSeconds(now()));

        session()->forget('start_time');


        Response::create([
            'user_id'=>auth()->id(),
            'survey_id'=>$id,
            'answers'=>$str,
            'duration'=>$dura
        ]);

        return redirect()->route('survey.view',['id'=>$id]);
    }


    public function view($id){
        $survey = Survey::findOrFail($id);
        $responses = Response::where('survey_id',$id)->get()->reverse();

        return(view('pages.responses-view', ['survey' => $survey, 'responses' => $responses]));
    }

    public function analysis($id)
    {
        $survey = Survey::with('questions')
            ->findOrFail($id);

        $responses = Response::where('survey_id', $id)->get();

        $avg_time = 0;
        foreach($responses as $r){
            $avg_time += $r['duration'];
        }
        $avg_time = ceil($avg_time/count($responses));

        $analysis = [];

        $ans_ind = 0;
        foreach ($survey->questions as $question) {

            $reses = Response::where('survey_id',$survey->id)->get();

            $all_responses = [];
            foreach($reses as $res){
                $all_responses[] = explode('|', $res->answers);
            }


            $answers = [];

            foreach($all_responses as $resp){
                $i = 0;
                foreach($resp as $ans){
                    if($i == $ans_ind){
                        $answers[] = $ans;
                    }
                    $i++;
                }
            }

            if ($question->type === 'choice') {

                $counts = [];

                foreach ($answers as $answer) {
                    $counts[$answer] = ($counts[$answer] ?? 0) + 1;
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
                    'type' => 'choice',
                    'total' => count($answers),
                    'results' => $percentages,
                    'private' => false
                ];}else{
                    $analysis[$question->id] = [
                    'question' => $question->question,
                    'private' => true
                    ];
                }

            } else {

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
