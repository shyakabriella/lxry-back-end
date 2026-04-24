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
use Illuminate\Http\Request;
use App\Http\Controllers\Api\WelcomeSlideController;
use App\Http\Controllers\Api\Section5LuxuryController;
use App\Http\Controllers\Api\Section6GalleryController;
use App\Http\Controllers\Api\Section7FitnessController;
use App\Http\Controllers\Api\Section8ParkingController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;
use App\Http\Controllers\Api\Section9RestaurantBarController;
use App\Http\Controllers\Api\Section10SaunaController;
use App\Http\Controllers\Api\Section11PoolController;
use App\Http\Controllers\Api\Section12FamilyKidsController;
use Illuminate\Support\Facades\Route;


// ==========================================
// PUBLIC ROUTES (No authentication required)
// These are for React frontend - anyone can view
// ==========================================

// SECTION 1-4: WELCOME SLIDES (Public - View only)
Route::get('/welcome-slides', [WelcomeSlideController::class, 'index']);
Route::get('/welcome-slides/{id}', [WelcomeSlideController::class, 'show']);

// SECTION 5: LUXURY SECTION (Public - View only)
Route::get('/section5/luxury', [Section5LuxuryController::class, 'getSection']);

// SECTION 6: IMAGE GALLERY (Public - View only)
Route::get('/section6/gallery', [Section6GalleryController::class, 'getActiveImages']);

// SECTION 7: FITNESS CENTER (Public - View only)
Route::get('/section7/fitness', [Section7FitnessController::class, 'getSection']);

// SECTION 8: PARKING FACILITIES (Public - View only)
Route::get('/section8/parking', [Section8ParkingController::class, 'getSection']);

// HOME PAGE SECTION TWO (Public - View only)
Route::get('/home-page-section-two', [HomePageSectionTwoController::class, 'index']);

// ==========================================
// AUTHENTICATION ROUTES (Public - Anyone can register/login)
// ==========================================
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
// ==========================================
// PROTECTED ADMIN ROUTES (Authentication required)
// Only logged-in users with valid token can access these
// ==========================================
// Route::middleware('auth:sanctum')->group(function () {
    
    // SECTION 1-4: WELCOME SLIDES (Admin)
    Route::post('/admin/welcome-slides', [WelcomeSlideController::class, 'store']);
    Route::put('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'update']);
    Route::delete('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'destroy']);
    
    // SECTION 5: LUXURY SECTION (Admin)
    Route::post('/admin/section5/luxury', [Section5LuxuryController::class, 'store']);
    Route::put('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'update']);
    Route::delete('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'destroy']);
    
    // SECTION 6: IMAGE GALLERY (Admin)
    Route::post('/admin/section6/gallery', [Section6GalleryController::class, 'store']);
    Route::put('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'update']);
    Route::delete('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'destroy']);
    
    // SECTION 7: FITNESS CENTER (Admin)
    Route::post('/admin/section7/fitness', [Section7FitnessController::class, 'store']);
    Route::put('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'update']);
    Route::delete('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'destroy']);
    
    // SECTION 8: PARKING FACILITIES (Admin)
    Route::post('/admin/section8/parking', [Section8ParkingController::class, 'store']);
    Route::put('/admin/section8/parking/{id}', [Section8ParkingController::class, 'update']);
    Route::delete('/admin/section8/parking/{id}', [Section8ParkingController::class, 'destroy']);
    
    // HOME PAGE SECTION TWO (Admin)
    Route::post('/admin/home-page-section-two', [HomePageSectionTwoController::class, 'store']);
    Route::put('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'update']);
    Route::delete('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'destroy']);
    
    // You can add more protected routes here later
    // Example: Route::get('/user', [UserController::class, 'getUser']);

    
// ============ SECTION 9: RESTAURANT & BAR EXPERIENCE ============
Route::get('/section9/restaurant-bar', [Section9RestaurantBarController::class, 'getSection']);
Route::post('/admin/section9/restaurant-bar', [Section9RestaurantBarController::class, 'store']);
Route::put('/admin/section9/restaurant-bar/{id}', [Section9RestaurantBarController::class, 'update']);
Route::delete('/admin/section9/restaurant-bar/{id}', [Section9RestaurantBarController::class, 'destroy']);

// Public route (frontend - view only)
Route::get('/section10/sauna', [Section10SaunaController::class, 'getSection']);

// Admin routes (manage content via Postman)
Route::post('/admin/section10/sauna', [Section10SaunaController::class, 'store']);        // Create or update content + images
Route::put('/admin/section10/sauna/{id}', [Section10SaunaController::class, 'updateImages']); // Update images only
Route::delete('/admin/section10/sauna/{id}', [Section10SaunaController::class, 'destroy']);   // Delete everything


// ============ SECTION 11: INFINITY POOL EXPERIENCE ============
Route::get('/section11/pool', [Section11PoolController::class, 'getSection']);
Route::post('/admin/section11/pool', [Section11PoolController::class, 'store']);
Route::put('/admin/section11/pool/{id}', [Section11PoolController::class, 'update']);
Route::delete('/admin/section11/pool/{id}', [Section11PoolController::class, 'destroy']);


// ============ SECTION 12: FAMILY EXPERIENCE & KIDS ZONE ============
Route::get('/section12/family-kids', [Section12FamilyKidsController::class, 'getSection']);
Route::post('/admin/section12/family-kids', [Section12FamilyKidsController::class, 'store']);
Route::put('/admin/section12/family-kids/{id}', [Section12FamilyKidsController::class, 'update']);
Route::delete('/admin/section12/family-kids/{id}', [Section12FamilyKidsController::class, 'destroy']);




// });
