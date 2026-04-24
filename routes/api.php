<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;
use App\Http\Controllers\API\HomeSectionThreeController;
use App\Http\Controllers\API\HomeSectionFourController;
use App\Http\Controllers\API\HomeSectionFiveController;
use App\Http\Controllers\API\Section6GalleryController;
use App\Http\Controllers\API\Section7FitnessController;
use App\Http\Controllers\API\Section8ParkingController;
use App\Http\Controllers\API\RestaurantMenuItemController;
use App\Http\Controllers\API\RestaurantBookingController;

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

// Section 6 Gallery
Route::get('section-6-gallery/active', [Section6GalleryController::class, 'getActiveImages']);

// Section 7 Fitness
Route::get('section-7-fitness', [Section7FitnessController::class, 'getSection']);

// Section 8 Parking
Route::get('section-8-parking', [Section8ParkingController::class, 'getSection']);

// Restaurant Menu Items
Route::get('restaurant-menu-items', [RestaurantMenuItemController::class, 'index']);
Route::get('restaurant-menu-items/active', [RestaurantMenuItemController::class, 'active']);
Route::get('restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'show']);

// Restaurant Bookings - customer creates booking/order here
Route::post('restaurant-bookings', [RestaurantBookingController::class, 'store']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', [RegisterController::class, 'me']);
    Route::post('logout', [RegisterController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Home Page Section Two
    |--------------------------------------------------------------------------
    */
    Route::post('admin/home-page-section-two', [HomePageSectionTwoController::class, 'store']);
    Route::put('admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'update']);
    Route::delete('admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Home Section Three
    |--------------------------------------------------------------------------
    */
    Route::post('home-section-threes', [HomeSectionThreeController::class, 'store']);
    Route::put('home-section-threes/{id}', [HomeSectionThreeController::class, 'update']);
    Route::delete('home-section-threes/{id}', [HomeSectionThreeController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Home Section Four
    |--------------------------------------------------------------------------
    */
    Route::post('home-section-fours', [HomeSectionFourController::class, 'store']);
    Route::put('home-section-fours/{id}', [HomeSectionFourController::class, 'update']);
    Route::delete('home-section-fours/{id}', [HomeSectionFourController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Home Section Five
    |--------------------------------------------------------------------------
    */
    Route::post('home-section-fives', [HomeSectionFiveController::class, 'store']);
    Route::put('home-section-fives/{id}', [HomeSectionFiveController::class, 'update']);
    Route::delete('home-section-fives/{id}', [HomeSectionFiveController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Section 6 Gallery
    |--------------------------------------------------------------------------
    */
    Route::post('section-6-gallery', [Section6GalleryController::class, 'store']);
    Route::put('section-6-gallery/{id}', [Section6GalleryController::class, 'update']);
    Route::delete('section-6-gallery/{id}', [Section6GalleryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Section 7 Fitness
    |--------------------------------------------------------------------------
    */
    Route::post('section-7-fitness', [Section7FitnessController::class, 'store']);
    Route::put('section-7-fitness/{id}', [Section7FitnessController::class, 'update']);
    Route::delete('section-7-fitness/{id}', [Section7FitnessController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Section 8 Parking
    |--------------------------------------------------------------------------
    */
    Route::post('section-8-parking', [Section8ParkingController::class, 'store']);
    Route::put('section-8-parking/{id}', [Section8ParkingController::class, 'update']);
    Route::delete('section-8-parking/{id}', [Section8ParkingController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Restaurant Menu Items
    |--------------------------------------------------------------------------
    */
    Route::post('restaurant-menu-items', [RestaurantMenuItemController::class, 'store']);
    Route::put('restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);
    Route::delete('restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Restaurant Bookings - admin/authorized access
    |--------------------------------------------------------------------------
    */
    Route::get('restaurant-bookings', [RestaurantBookingController::class, 'index']);
    Route::get('restaurant-bookings/{id}', [RestaurantBookingController::class, 'show']);
    Route::put('restaurant-bookings/{id}', [RestaurantBookingController::class, 'update']);
    Route::delete('restaurant-bookings/{id}', [RestaurantBookingController::class, 'destroy']);
});