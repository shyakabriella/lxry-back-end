<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;
use App\Http\Controllers\API\HomeSectionThreeController;
use App\Http\Controllers\API\HomeSectionFourController;
use App\Http\Controllers\API\HomeSectionFiveController;
use App\Http\Controllers\API\RestaurantMenuItemController;

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

// Home Page Section Two
Route::get('home-page-section-two', [HomePageSectionTwoController::class, 'index']);

// Home Section Three
Route::get('home-section-threes', [HomeSectionThreeController::class, 'index']);
Route::get('home-section-threes/{id}', [HomeSectionThreeController::class, 'show']);

// Home Section Four
Route::get('home-section-fours', [HomeSectionFourController::class, 'index']);
Route::get('home-section-fours/active', [HomeSectionFourController::class, 'active']);
Route::get('home-section-fours/{id}', [HomeSectionFourController::class, 'show']);

// Home Section Five
Route::get('home-section-fives', [HomeSectionFiveController::class, 'index']);
Route::get('home-section-fives/active', [HomeSectionFiveController::class, 'active']);
Route::get('home-section-fives/{id}', [HomeSectionFiveController::class, 'show']);

// Restaurant Menu Items
Route::get('restaurant-menu-items', [RestaurantMenuItemController::class, 'index']);
Route::get('restaurant-menu-items/active', [RestaurantMenuItemController::class, 'active']);
Route::get('restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [RegisterController::class, 'me']);
    Route::post('logout', [RegisterController::class, 'logout']);

    // Home Page Section Two
    Route::post('admin/home-page-section-two', [HomePageSectionTwoController::class, 'store']);
    Route::put('admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'update']);
    Route::delete('admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'destroy']);

    // Home Section Three
    Route::post('home-section-threes', [HomeSectionThreeController::class, 'store']);
    Route::post('home-section-threes/{id}', [HomeSectionThreeController::class, 'update']);
    Route::delete('home-section-threes/{id}', [HomeSectionThreeController::class, 'destroy']);

    // Home Section Four
    Route::post('home-section-fours', [HomeSectionFourController::class, 'store']);
    Route::post('home-section-fours/{id}', [HomeSectionFourController::class, 'update']);
    Route::delete('home-section-fours/{id}', [HomeSectionFourController::class, 'destroy']);

    // Home Section Five
    Route::post('home-section-fives', [HomeSectionFiveController::class, 'store']);
    Route::post('home-section-fives/{id}', [HomeSectionFiveController::class, 'update']);
    Route::delete('home-section-fives/{id}', [HomeSectionFiveController::class, 'destroy']);

    // Restaurant Menu Items
    Route::post('restaurant-menu-items', [RestaurantMenuItemController::class, 'store']);
    Route::post('restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);
    Route::delete('restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'destroy']);
});