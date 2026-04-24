<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeSectionThreeController;
use App\Http\Controllers\API\HomeSectionFourController;
use App\Http\Controllers\API\HomeSectionFiveController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('home-section-threes', [HomeSectionThreeController::class, 'index']);
Route::get('home-section-threes/{id}', [HomeSectionThreeController::class, 'show']);

Route::get('home-section-fours', [HomeSectionFourController::class, 'index']);
Route::get('home-section-fours/active', [HomeSectionFourController::class, 'active']);
Route::get('home-section-fours/{id}', [HomeSectionFourController::class, 'show']);

Route::get('home-section-fives', [HomeSectionFiveController::class, 'index']);
Route::get('home-section-fives/active', [HomeSectionFiveController::class, 'active']);
Route::get('home-section-fives/{id}', [HomeSectionFiveController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [RegisterController::class, 'me']);
    Route::post('logout', [RegisterController::class, 'logout']);

    Route::post('home-section-threes', [HomeSectionThreeController::class, 'store']);
    Route::post('home-section-threes/{id}', [HomeSectionThreeController::class, 'update']);
    Route::delete('home-section-threes/{id}', [HomeSectionThreeController::class, 'destroy']);

    Route::post('home-section-fours', [HomeSectionFourController::class, 'store']);
    Route::post('home-section-fours/{id}', [HomeSectionFourController::class, 'update']);
    Route::delete('home-section-fours/{id}', [HomeSectionFourController::class, 'destroy']);

    Route::post('home-section-fives', [HomeSectionFiveController::class, 'store']);
    Route::post('home-section-fives/{id}', [HomeSectionFiveController::class, 'update']);
    Route::delete('home-section-fives/{id}', [HomeSectionFiveController::class, 'destroy']);
});