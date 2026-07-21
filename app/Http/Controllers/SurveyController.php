<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function index(){
        return view('pages.index');
    }

    public function show(){
        $surveys = Survey::all();
        return view('pages.survey-show-all', ['surveys'=>$surveys]);
    }

    public function showCreate(){
        return view('pages.survey-create');
    }
}
