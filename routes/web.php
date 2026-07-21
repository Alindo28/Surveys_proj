<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::controller(SurveyController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/survey', 'show')->name('survey_home');
});


Route::middleware('guest')->controller(AuthController::class)->group(function(){
    Route::get('/auth/login', 'showLogin');
    Route::get('/auth/register', 'showRegister');
    Route::post('/auth/login', 'login')->name('login');
    Route::post('/auth/register', 'register')->name('register');
    // Route::post('/auth/login');
    // Route::post('/auth/register');
});

Route::middleware('auth')->group(function(){
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/survey/create', [SurveyController::class, 'showCreate'])->name('show.survey_create');
});




