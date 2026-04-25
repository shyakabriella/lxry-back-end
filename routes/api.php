<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Controllers - Namespace Imports
|--------------------------------------------------------------------------
| Grouped by logical location to ensure readability.
*/

// Authentication & Core
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\Api\WelcomeSlideController;

// Home Page Sections
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;
use App\Http\Controllers\API\HomeSectionThreeController;
use App\Http\Controllers\API\HomeSectionFourController;
use App\Http\Controllers\API\HomeSectionFiveController;

// Feature Sections
use App\Http\Controllers\Api\Section5LuxuryController;
use App\Http\Controllers\API\Section6GalleryController;
use App\Http\Controllers\API\Section7FitnessController;
use App\Http\Controllers\API\Section8ParkingController;
use App\Http\Controllers\API\Section9RestaurantBarController;
use App\Http\Controllers\API\Section10SaunaController;
use App\Http\Controllers\API\Section11PoolController;
use App\Http\Controllers\API\Section12FamilyKidsController;



// Restaurant & Booking
use App\Http\Controllers\API\RestaurantMenuItemController;
use App\Http\Controllers\API\RestaurantBookingController;

//wedding section 

use App\Http\Controllers\Api\Wedding\WeddingSlideController;    
use App\Http\Controllers\Api\Wedding\WeddingSection1VenueController;
use App\Http\Controllers\Api\Wedding\WeddingSection2EasyPlanController;
use App\Http\Controllers\Api\Wedding\WeddingSection3ApartmentController;
use App\Http\Controllers\Api\Wedding\WeddingSection4AccommodationController;
use App\Http\Controllers\Api\Wedding\WeddingSection5LocationController;
use App\Http\Controllers\Api\Wedding\WeddingSection6GalleryController;

// =========================================================================
// PUBLIC ROUTES
// Accessible by the React frontend without authentication.
// =========================================================================

// Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Welcome Section
Route::get('/welcome-slides', [WelcomeSlideController::class, 'index']);
Route::get('/welcome-slides/{id}', [WelcomeSlideController::class, 'show']);

// Home Sections (View Only)
Route::get('/home-page-section-two', [HomePageSectionTwoController::class, 'index']);
Route::get('/home-section-threes', [HomeSectionThreeController::class, 'index']);
Route::get('/home-section-threes/{id}', [HomeSectionThreeController::class, 'show']);
Route::get('/home-section-fours', [HomeSectionFourController::class, 'index']);
Route::get('/home-section-fours/active', [HomeSectionFourController::class, 'active']);
Route::get('/home-section-fours/{id}', [HomeSectionFourController::class, 'show']);
Route::get('/home-section-fives', [HomeSectionFiveController::class, 'index']);
Route::get('/home-section-fives/active', [HomeSectionFiveController::class, 'active']);
Route::get('/home-section-fives/{id}', [HomeSectionFiveController::class, 'show']);

// Facility Sections (View Only)
Route::get('/section5/luxury', [Section5LuxuryController::class, 'getSection']);
Route::get('/section6/gallery', [Section6GalleryController::class, 'getActiveImages']);
Route::get('/section7/fitness', [Section7FitnessController::class, 'getSection']);
Route::get('/section8/parking', [Section8ParkingController::class, 'getSection']);
Route::get('/section9/restaurant-bar', [Section9RestaurantBarController::class, 'getSection']);
Route::get('/section10/sauna', [Section10SaunaController::class, 'getSection']);
Route::get('/section11/pool', [Section11PoolController::class, 'getSection']);
Route::get('/section12/family-kids', [Section12FamilyKidsController::class, 'getSection']);


// Wedding Slides (Public)
Route::get('/wedding/slides', [WeddingSlideController::class, 'getSlides']);
// Wedding Section 1 (Public)
Route::get('/wedding/section1/venue', [WeddingSection1VenueController::class, 'getSection']);
Route::get('/wedding/section2/easy-plan', [WeddingSection2EasyPlanController::class, 'getSection']);
Route::get('/wedding/section3/apartment', [WeddingSection3ApartmentController::class, 'getSection']);
Route::get('/wedding/section4/accommodations', [WeddingSection4AccommodationController::class, 'getSection']);
Route::get('/wedding/section5/location', [WeddingSection5LocationController::class, 'getSection']);
Route::get('/wedding/section6/gallery', [WeddingSection6GalleryController::class, 'getGallery']);


// Restaurant
Route::get('/restaurant-menu-items', [RestaurantMenuItemController::class, 'index']);
Route::get('/restaurant-menu-items/active', [RestaurantMenuItemController::class, 'active']);
Route::get('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'show']);
Route::post('/restaurant-bookings', [RestaurantBookingController::class, 'store']); // Customer Booking


// =========================================================================
// PROTECTED ROUTES
// Requires "auth:sanctum" middleware (Admin/User access)
// =========================================================================
Route::middleware('auth:sanctum')->group(function () {
    
    // Auth Management
    Route::get('me', [RegisterController::class, 'me']);
    Route::post('logout', [RegisterController::class, 'logout']);

    // --- Admin Management Endpoints ---

    // Welcome Slides
    Route::post('/admin/welcome-slides', [WelcomeSlideController::class, 'store']);
    Route::put('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'update']);
    Route::delete('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'destroy']);

    // Luxury & Gallery
    Route::post('/admin/section5/luxury', [Section5LuxuryController::class, 'store']);
    Route::put('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'update']);
    Route::delete('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'destroy']);

    Route::post('/admin/section6/gallery', [Section6GalleryController::class, 'store']);
    Route::put('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'update']);
    Route::delete('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'destroy']);

    // Fitness & Parking
    Route::post('/admin/section7/fitness', [Section7FitnessController::class, 'store']);
    Route::put('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'update']);
    Route::delete('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'destroy']);

    Route::post('/admin/section8/parking', [Section8ParkingController::class, 'store']);
    Route::put('/admin/section8/parking/{id}', [Section8ParkingController::class, 'update']);
    Route::delete('/admin/section8/parking/{id}', [Section8ParkingController::class, 'destroy']);

    // Restaurant/Bar & Experience Sections
    Route::post('/admin/section9/restaurant-bar', [Section9RestaurantBarController::class, 'store']);
    Route::put('/admin/section9/restaurant-bar/{id}', [Section9RestaurantBarController::class, 'update']);
    Route::delete('/admin/section9/restaurant-bar/{id}', [Section9RestaurantBarController::class, 'destroy']);

    Route::post('/admin/section10/sauna', [Section10SaunaController::class, 'store']);
    Route::put('/admin/section10/sauna/{id}', [Section10SaunaController::class, 'updateImages']);
    Route::delete('/admin/section10/sauna/{id}', [Section10SaunaController::class, 'destroy']);

    Route::post('/admin/section11/pool', [Section11PoolController::class, 'store']);
    Route::put('/admin/section11/pool/{id}', [Section11PoolController::class, 'update']);
    Route::delete('/admin/section11/pool/{id}', [Section11PoolController::class, 'destroy']);

    Route::post('/admin/section12/family-kids', [Section12FamilyKidsController::class, 'store']);
    Route::put('/admin/section12/family-kids/{id}', [Section12FamilyKidsController::class, 'update']);
    Route::delete('/admin/section12/family-kids/{id}', [Section12FamilyKidsController::class, 'destroy']);

    // Content Management (Home Sections)
    Route::post('/admin/home-page-section-two', [HomePageSectionTwoController::class, 'store']);
    Route::put('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'update']);
    Route::delete('/admin/home-page-section-two/{id}', [HomePageSectionTwoController::class, 'destroy']);

    Route::post('/home-section-threes', [HomeSectionThreeController::class, 'store']);
    Route::put('/home-section-threes/{id}', [HomeSectionThreeController::class, 'update']);
    Route::delete('/home-section-threes/{id}', [HomeSectionThreeController::class, 'destroy']);

    Route::post('/home-section-fours', [HomeSectionFourController::class, 'store']);
    Route::put('/home-section-fours/{id}', [HomeSectionFourController::class, 'update']);
    Route::delete('/home-section-fours/{id}', [HomeSectionFourController::class, 'destroy']);

    Route::post('/home-section-fives', [HomeSectionFiveController::class, 'store']);
    Route::put('/home-section-fives/{id}', [HomeSectionFiveController::class, 'update']);
    Route::delete('/home-section-fives/{id}', [HomeSectionFiveController::class, 'destroy']);

    Route::post('/restaurant-menu-items', [RestaurantMenuItemController::class, 'store']);
    Route::put('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);
    Route::delete('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'destroy']);

    // Admin-only Restaurant Booking management
    Route::get('/restaurant-bookings', [RestaurantBookingController::class, 'index']);
    Route::get('/restaurant-bookings/{id}', [RestaurantBookingController::class, 'show']);
    Route::put('/restaurant-bookings/{id}', [RestaurantBookingController::class, 'update']);
    Route::delete('/restaurant-bookings/{id}', [RestaurantBookingController::class, 'destroy']);

    // Wedding Slides Management (Admin)
Route::post('/admin/wedding/slides', [WeddingSlideController::class, 'store']);
Route::put('/admin/wedding/slides/{id}', [WeddingSlideController::class, 'update']);
Route::delete('/admin/wedding/slides/{id}', [WeddingSlideController::class, 'destroy']);

// Wedding Section 1 Management (Admin)
Route::post('/admin/wedding/section1/venue', [WeddingSection1VenueController::class, 'store']);
Route::put('/admin/wedding/section1/venue/{id}', [WeddingSection1VenueController::class, 'update']);
Route::delete('/admin/wedding/section1/venue/{id}', [WeddingSection1VenueController::class, 'destroy']);

Route::post('/admin/wedding/section2/easy-plan', [WeddingSection2EasyPlanController::class, 'store']);
Route::put('/admin/wedding/section2/easy-plan/{id}', [WeddingSection2EasyPlanController::class, 'update']);
Route::delete('/admin/wedding/section2/easy-plan/{id}', [WeddingSection2EasyPlanController::class, 'destroy']);
// Wedding Section 3 Management (Admin)
Route::post('/admin/wedding/section3/apartment', [WeddingSection3ApartmentController::class, 'store']);
Route::put('/admin/wedding/section3/apartment/{id}', [WeddingSection3ApartmentController::class, 'update']);
Route::delete('/admin/wedding/section3/apartment/{id}', [WeddingSection3ApartmentController::class, 'destroy']);
// Add inside PROTECTED ROUTES (auth:sanctum group)
Route::post('/admin/wedding/section4/accommodations', [WeddingSection4AccommodationController::class, 'store']);
Route::put('/admin/wedding/section4/accommodations/{id}', [WeddingSection4AccommodationController::class, 'update']);
Route::delete('/admin/wedding/section4/accommodations/{id}', [WeddingSection4AccommodationController::class, 'destroy']);
// Add inside PROTECTED ROUTES (auth:sanctum group)
Route::post('/admin/wedding/section5/location', [WeddingSection5LocationController::class, 'store']);
Route::put('/admin/wedding/section5/location/{id}', [WeddingSection5LocationController::class, 'update']);
Route::delete('/admin/wedding/section5/location/{id}', [WeddingSection5LocationController::class, 'destroy']);

// Add inside PROTECTED ROUTES (auth:sanctum group)
Route::post('/admin/wedding/section6/gallery', [WeddingSection6GalleryController::class, 'store']);
Route::put('/admin/wedding/section6/gallery/{id}', [WeddingSection6GalleryController::class, 'update']);
Route::delete('/admin/wedding/section6/gallery/{id}', [WeddingSection6GalleryController::class, 'destroy']);
});