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



// ============ SECTION 1-4: WELCOME SLIDES ============
Route::get('/welcome-slides', [WelcomeSlideController::class, 'index']);
Route::get('/welcome-slides/{id}', [WelcomeSlideController::class, 'show']);
Route::post('/admin/welcome-slides', [WelcomeSlideController::class, 'store']);
Route::put('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'update']);
Route::delete('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'destroy']);

// ============ SECTION 5: LUXURY SECTION ============
Route::get('/section5/luxury', [Section5LuxuryController::class, 'getSection']);
Route::post('/admin/section5/luxury', [Section5LuxuryController::class, 'store']);
Route::put('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'update']);
Route::delete('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'destroy']);

// ============ SECTION 6: IMAGE GALLERY ============
// Public routes for React frontend (users see this)
Route::get('/section6/gallery', [Section6GalleryController::class, 'getActiveImages']);

// Admin routes for you (manage via Postman)
Route::post('/admin/section6/gallery', [Section6GalleryController::class, 'store']);
Route::put('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'update']);
Route::delete('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'destroy']);

// section 7 


// ============ SECTION 7: FITNESS CENTER & WELLNESS ZONE ============
Route::get('/section7/fitness', [Section7FitnessController::class, 'getSection']);
Route::post('/admin/section7/fitness', [Section7FitnessController::class, 'store']);
Route::put('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'update']);
Route::delete('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'destroy']);


// ============ SECTION 8: PARKING FACILITIES ============
Route::get('/section8/parking', [Section8ParkingController::class, 'getSection']);
Route::post('/admin/section8/parking', [Section8ParkingController::class, 'store']);
Route::put('/admin/section8/parking/{id}', [Section8ParkingController::class, 'update']);
Route::delete('/admin/section8/parking/{id}', [Section8ParkingController::class, 'destroy']);


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
