<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContextController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\RigController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;

Route::controller(SurveyController::class)->group(function(){
    Route::get('/', 'index')->name('home');
    Route::get('/survey', 'show')->name('survey.home');
});


Route::middleware('guest')->controller(AuthController::class)->group(function(){
    Route::get('/auth/login', 'showLogin');
    Route::get('/auth/register', 'showRegister');
    Route::post('/auth/login', 'login')->name('login');
    Route::post('/auth/register', 'register')->name('register');

});

Route::middleware('auth')->group(function(){
    Route::post('/auth/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/survey/context/view/{id}', [ContextController::class, 'view'])->name('context.show');
    Route::get('/survey/context/create', [ContextController::class, 'showCreate'])->name('survey.create.context.show');
    Route::post('/survey/context/create', [ContextController::class, 'create'])->name('survey.create.context');

    Route::get('/survey/context/my/{id}', [ContextController::class, 'showEdit'])->name('context.edit.show');
    Route::put('/survey/context/my/{id}', [ContextController::class, 'update'])->name('context.edit');
    Route::delete('/survey/context/my/{id}', [ContextController::class, 'delete'])->name('context.delete');

    Route::get('/survey/create/{context_id}', [SurveyController::class, 'showCreate'])->name('survey.create.show');
    Route::post('/survey/create/{context_id}', [SurveyController::class, 'create'])->name('survey.create');

    Route::get('/survey/view/{id}', [SurveyController::class, 'view'])->name('survey.view');
    Route::get('/survey/my', [SurveyController::class, 'viewMy'])->name('survey.view.my');

    Route::patch('/survey/my/{id}', [SurveyController::class, 'changeStatus'])->name('survey.edit.status');
    Route::put('/survey/my/{id}', [SurveyController::class, 'update'])->name('survey.edit');
    Route::get('/survey/my/{id}', [SurveyController::class, 'showEdit'])->name('survey.edit.show');
    Route::delete('/survey/my/{id}', [SurveyController::class, 'delete'])->name('survey.delete');

    Route::post('/survey/response/{id}', [ResponseController::class, 'create'])->name('response.create');
    Route::get('/survey/response/{id}', [ResponseController::class, 'view'])->name('response.view');
    Route::get('/survey/response/analysis/{id}', [ResponseController::class, 'analysis'])->name('response.analysis');

    Route::get('/profile/home', [ProfileController::class, 'index'])->name('profile.home')->middleware('check.subscription');;
    Route::delete('/profile', [ProfileController::class, 'delete'])->name('profile.delete');
    Route::get('/profile/change-password', [ProfileController::class, 'showChangePassword'])->name('profile.update.password.show');
    Route::put('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.update.password');
    Route::get('/profile/subscriptions', [ProfileController::class, 'showSubscription'])->name('profile.subsciptions.show')->middleware('check.subscription');
    Route::patch('/profile/subscriptions/purchase', [ProfileController::class, 'purchase'])->name('profile.subsciptions.purchase')->middleware('check.subscription');


    Route::post('rig/access/{id}', [RigController::class, 'access'])->name('rig.access')->middleware('check.subscription');
    Route::get('rig/enter/{id}', [RigController::class, 'enter'])->name('rig.enter')->middleware('check.subscription');
    Route::post('rig/enter/{id}', [RigController::class, 'create'])->name('rig.create')->middleware('check.subscription');
    Route::delete('rig/enter/{id}', [RigController::class, 'delete'])->name('rig.delete');
    Route::patch('/rig/enter/{id}', [RigController::class, 'toggle'])->name('rig.toggle');
});




