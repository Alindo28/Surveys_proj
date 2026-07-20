<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::controller(SurveyController::class)->group(function(){
    Route::get('/', 'index')->name('home');
});


Route::controller(AuthController::class)->group(function(){
    Route::get('/auth/login', 'showLogin')->name('login');
    Route::get('/auth/register', 'showRegister')->name('register');
    // Route::post('/auth/login');
    // Route::post('/auth/register');
});


