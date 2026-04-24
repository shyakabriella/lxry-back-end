<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WelcomeSlideController;
use App\Http\Controllers\Api\Section5LuxuryController;
use App\Http\Controllers\Api\Section6GalleryController;  // ← ADD THIS LINE
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Section7FitnessController;
use App\Http\Controllers\Api\Section8ParkingController;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;



Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});



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

    // Home Page Section Two Routes
    Route::get('/home-page-section-two', [HomePageSectionTwoController::class, 'index']);
    Route::post('/admin/home-page-section-two', [HomePageSectionTwoController::class, 'store']);
    Route::put('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'update']);
    Route::delete('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'destroy']);

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

});
