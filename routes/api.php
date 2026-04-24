<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;


// Home Page Section Two Routes
Route::get('/home-page-section-two', [HomePageSectionTwoController::class, 'index']);
Route::post('/admin/home-page-section-two', [HomePageSectionTwoController::class, 'store']);
Route::put('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'update']);
Route::delete('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'destroy']);

// 🔐 Auth Routes
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// 🔒 Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // add protected APIs here later
});