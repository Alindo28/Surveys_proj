<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::controller(SurveyController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/survey', 'show')->name('survey_home');
    Route::get('/survey/create', 'showCreate')->name('show.survey_create');
});


Route::controller(AuthController::class)->group(function(){
    Route::get('/auth/login', 'showLogin')->name('show.login');
    Route::get('/auth/register', 'showRegister')->name('show.register');
    Route::post('/auth/login', 'login')->name('action.login');
    Route::post('/auth/register', 'register')->name('action.register');
    // Route::post('/auth/login');
    // Route::post('/auth/register');
});


