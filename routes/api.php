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
use App\Http\Controllers\API\WelcomeSlideController;

// Home Page Sections
use App\Http\Controllers\API\HomeSectionOneController;
use App\Http\Controllers\API\HomeAPI\HomePageSectionTwoController;
use App\Http\Controllers\API\HomeSectionThreeController;
use App\Http\Controllers\API\HomeSectionFourController;
use App\Http\Controllers\API\HomeSectionFiveController;

// Feature Sections
use App\Http\Controllers\API\Section5LuxuryController;
use App\Http\Controllers\API\Section6GalleryController;
use App\Http\Controllers\API\Section7FitnessController;
use App\Http\Controllers\API\Section8ParkingController;
use App\Http\Controllers\API\Section9RestaurantBarController;
use App\Http\Controllers\API\Section10SaunaController;
use App\Http\Controllers\API\Section11PoolController;
use App\Http\Controllers\API\Section12FamilyKidsController;
use App\Http\Controllers\API\MassageSpaController;

// Restaurant & Booking
use App\Http\Controllers\API\RestaurantMenuCategoryController;
use App\Http\Controllers\API\RestaurantMenuItemController;
use App\Http\Controllers\API\RestaurantBookingController;

// Wedding Section
use App\Http\Controllers\API\Wedding\WeddingSlideController;
use App\Http\Controllers\API\Wedding\WeddingSection1VenueController;
use App\Http\Controllers\API\Wedding\WeddingSection2EasyPlanController;
use App\Http\Controllers\API\Wedding\WeddingSection3ApartmentController;
use App\Http\Controllers\API\Wedding\WeddingSection4AccommodationController;
use App\Http\Controllers\API\Wedding\WeddingSection5LocationController;
use App\Http\Controllers\API\Wedding\WeddingSection6GalleryController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
| Accessible by the React frontend without authentication.
|--------------------------------------------------------------------------
*/

// Authentication Routes
Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

// Welcome Section
Route::get('/welcome-slides', [WelcomeSlideController::class, 'index']);
Route::get('/welcome-slides/{id}', [WelcomeSlideController::class, 'show']);

// Home Sections - View Only
Route::get('/home-section-one', [HomeSectionOneController::class, 'index']);
Route::get('/home-section-one/{id}', [HomeSectionOneController::class, 'show']);

Route::get('/home-page-section-two', [HomePageSectionTwoController::class, 'index']);

Route::get('/home-section-threes', [HomeSectionThreeController::class, 'index']);
Route::get('/home-section-threes/{id}', [HomeSectionThreeController::class, 'show']);

Route::get('/home-section-fours', [HomeSectionFourController::class, 'index']);
Route::get('/home-section-fours/active', [HomeSectionFourController::class, 'active']);
Route::get('/home-section-fours/{id}', [HomeSectionFourController::class, 'show']);

Route::get('/home-section-fives', [HomeSectionFiveController::class, 'index']);
Route::get('/home-section-fives/active', [HomeSectionFiveController::class, 'active']);
Route::get('/home-section-fives/{id}', [HomeSectionFiveController::class, 'show']);

// Facility Sections - View Only
Route::get('/section5/luxury', [Section5LuxuryController::class, 'getSection']);
Route::get('/section6/gallery', [Section6GalleryController::class, 'getActiveImages']);
Route::get('/section7/fitness', [Section7FitnessController::class, 'getSection']);
Route::get('/section8/parking', [Section8ParkingController::class, 'getSection']);
Route::get('/section9/restaurant-bar', [Section9RestaurantBarController::class, 'getSection']);
Route::get('/section10/sauna', [Section10SaunaController::class, 'getSection']);
Route::get('/section11/pool', [Section11PoolController::class, 'getSection']);
Route::get('/section12/family-kids', [Section12FamilyKidsController::class, 'getSection']);

/*
|--------------------------------------------------------------------------
| Massage & Spa Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/massage-spa', [MassageSpaController::class, 'index']);

// Wedding Public Routes
Route::get('/wedding/slides', [WeddingSlideController::class, 'getSlides']);
Route::get('/wedding/section1/venue', [WeddingSection1VenueController::class, 'getSection']);
Route::get('/wedding/section2/easy-plan', [WeddingSection2EasyPlanController::class, 'getSection']);
Route::get('/wedding/section3/apartment', [WeddingSection3ApartmentController::class, 'getSection']);
Route::get('/wedding/section4/accommodations', [WeddingSection4AccommodationController::class, 'getSection']);
Route::get('/wedding/section5/location', [WeddingSection5LocationController::class, 'getSection']);
Route::get('/wedding/section6/gallery', [WeddingSection6GalleryController::class, 'getGallery']);

/*
|--------------------------------------------------------------------------
| Restaurant Public Routes
|--------------------------------------------------------------------------
*/

// Restaurant Menu Categories
Route::get('/restaurant-menu-categories', [RestaurantMenuCategoryController::class, 'index']);
Route::get('/restaurant-menu-categories/active', [RestaurantMenuCategoryController::class, 'active']);
Route::get('/restaurant-menu-categories/{id}', [RestaurantMenuCategoryController::class, 'show']);

// Restaurant Menu Items
Route::get('/restaurant-menu-items', [RestaurantMenuItemController::class, 'index']);
Route::get('/restaurant-menu-items/active', [RestaurantMenuItemController::class, 'active']);
Route::get('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'show']);

// Restaurant Bookings - Customer Booking
Route::post('/restaurant-bookings', [RestaurantBookingController::class, 'store']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
| Requires "auth:sanctum" middleware.
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | Auth Management
    |--------------------------------------------------------------------------
    */
    Route::get('me', [RegisterController::class, 'me']);
    Route::post('logout', [RegisterController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | Welcome Slides Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/welcome-slides', [WelcomeSlideController::class, 'store']);
    Route::put('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'update']);
    Route::delete('/admin/welcome-slides/{id}', [WelcomeSlideController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Home Sections Management
    |--------------------------------------------------------------------------
    */

    // Home Section One
    Route::post('/admin/home-section-one', [HomeSectionOneController::class, 'store']);
    Route::post('/admin/home-section-one/{id}', [HomeSectionOneController::class, 'update']);
    Route::put('/admin/home-section-one/{id}', [HomeSectionOneController::class, 'update']);
    Route::delete('/admin/home-section-one/{id}', [HomeSectionOneController::class, 'destroy']);

    // Home Page Section Two
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

    /*
    |--------------------------------------------------------------------------
    | Facility Sections Management
    |--------------------------------------------------------------------------
    */

    // Luxury
    Route::post('/admin/section5/luxury', [Section5LuxuryController::class, 'store']);
    Route::put('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'update']);
    Route::delete('/admin/section5/luxury/{id}', [Section5LuxuryController::class, 'destroy']);

    // Gallery
    Route::post('/admin/section6/gallery', [Section6GalleryController::class, 'store']);
    Route::put('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'update']);
    Route::delete('/admin/section6/gallery/{id}', [Section6GalleryController::class, 'destroy']);

    // Fitness
    Route::post('/admin/section7/fitness', [Section7FitnessController::class, 'store']);
    Route::put('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'update']);
    Route::delete('/admin/section7/fitness/{id}', [Section7FitnessController::class, 'destroy']);

    // Parking
    Route::post('/admin/section8/parking', [Section8ParkingController::class, 'store']);
    Route::put('/admin/section8/parking/{id}', [Section8ParkingController::class, 'update']);
    Route::delete('/admin/section8/parking/{id}', [Section8ParkingController::class, 'destroy']);

    // Restaurant / Bar Section
    Route::post('/admin/section9/restaurant-bar', [Section9RestaurantBarController::class, 'store']);
    Route::put('/admin/section9/restaurant-bar/{id}', [Section9RestaurantBarController::class, 'update']);
    Route::delete('/admin/section9/restaurant-bar/{id}', [Section9RestaurantBarController::class, 'destroy']);

    // Sauna
    Route::post('/admin/section10/sauna', [Section10SaunaController::class, 'store']);
    Route::put('/admin/section10/sauna/{id}', [Section10SaunaController::class, 'updateImages']);
    Route::delete('/admin/section10/sauna/{id}', [Section10SaunaController::class, 'destroy']);

    // Pool
    Route::post('/admin/section11/pool', [Section11PoolController::class, 'store']);
    Route::put('/admin/section11/pool/{id}', [Section11PoolController::class, 'update']);
    Route::delete('/admin/section11/pool/{id}', [Section11PoolController::class, 'destroy']);

    // Family & Kids
    Route::post('/admin/section12/family-kids', [Section12FamilyKidsController::class, 'store']);
    Route::put('/admin/section12/family-kids/{id}', [Section12FamilyKidsController::class, 'update']);
    Route::delete('/admin/section12/family-kids/{id}', [Section12FamilyKidsController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Massage & Spa Management
    |--------------------------------------------------------------------------
    */
    Route::get('/admin/massage-spa', [MassageSpaController::class, 'adminData']);

    Route::post('/admin/massage-spa/page', [MassageSpaController::class, 'savePage']);

    Route::post('/admin/massage-spa/items', [MassageSpaController::class, 'storeItem']);
    Route::put('/admin/massage-spa/items/{id}', [MassageSpaController::class, 'updateItem']);
    Route::post('/admin/massage-spa/items/{id}', [MassageSpaController::class, 'updateItem']);
    Route::delete('/admin/massage-spa/items/{id}', [MassageSpaController::class, 'destroyItem']);

    Route::post('/admin/massage-spa/benefits', [MassageSpaController::class, 'storeBenefit']);
    Route::put('/admin/massage-spa/benefits/{id}', [MassageSpaController::class, 'updateBenefit']);
    Route::delete('/admin/massage-spa/benefits/{id}', [MassageSpaController::class, 'destroyBenefit']);

    /*
    |--------------------------------------------------------------------------
    | Restaurant Menu Categories Management
    |--------------------------------------------------------------------------
    */
    Route::post('/restaurant-menu-categories', [RestaurantMenuCategoryController::class, 'store']);
    Route::put('/restaurant-menu-categories/{id}', [RestaurantMenuCategoryController::class, 'update']);
    Route::delete('/restaurant-menu-categories/{id}', [RestaurantMenuCategoryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Restaurant Menu Items Management
    |--------------------------------------------------------------------------
    */
    Route::post('/restaurant-menu-items', [RestaurantMenuItemController::class, 'store']);

    // Keep both PUT and POST update support.
    // PUT is standard. POST helps if your frontend still uses POST for update.
    Route::put('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);
    Route::post('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);

    Route::delete('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Restaurant Booking Management
    |--------------------------------------------------------------------------
    */
    Route::get('/restaurant-bookings', [RestaurantBookingController::class, 'index']);
    Route::get('/restaurant-bookings/{id}', [RestaurantBookingController::class, 'show']);
    Route::put('/restaurant-bookings/{id}', [RestaurantBookingController::class, 'update']);
    Route::delete('/restaurant-bookings/{id}', [RestaurantBookingController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Slides Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/slides', [WeddingSlideController::class, 'store']);
    Route::put('/admin/wedding/slides/{id}', [WeddingSlideController::class, 'update']);
    Route::delete('/admin/wedding/slides/{id}', [WeddingSlideController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Section 1 Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section1/venue', [WeddingSection1VenueController::class, 'store']);
    Route::put('/admin/wedding/section1/venue/{id}', [WeddingSection1VenueController::class, 'update']);
    Route::delete('/admin/wedding/section1/venue/{id}', [WeddingSection1VenueController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Section 2 Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section2/easy-plan', [WeddingSection2EasyPlanController::class, 'store']);
    Route::put('/admin/wedding/section2/easy-plan/{id}', [WeddingSection2EasyPlanController::class, 'update']);
    Route::delete('/admin/wedding/section2/easy-plan/{id}', [WeddingSection2EasyPlanController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Section 3 Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section3/apartment', [WeddingSection3ApartmentController::class, 'store']);
    Route::put('/admin/wedding/section3/apartment/{id}', [WeddingSection3ApartmentController::class, 'update']);
    Route::delete('/admin/wedding/section3/apartment/{id}', [WeddingSection3ApartmentController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Section 4 Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section4/accommodations', [WeddingSection4AccommodationController::class, 'store']);
    Route::put('/admin/wedding/section4/accommodations/{id}', [WeddingSection4AccommodationController::class, 'update']);
    Route::delete('/admin/wedding/section4/accommodations/{id}', [WeddingSection4AccommodationController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Section 5 Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section5/location', [WeddingSection5LocationController::class, 'store']);
    Route::put('/admin/wedding/section5/location/{id}', [WeddingSection5LocationController::class, 'update']);
    Route::delete('/admin/wedding/section5/location/{id}', [WeddingSection5LocationController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Section 6 Gallery Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section6/gallery', [WeddingSection6GalleryController::class, 'store']);
    Route::put('/admin/wedding/section6/gallery/{id}', [WeddingSection6GalleryController::class, 'update']);
    Route::delete('/admin/wedding/section6/gallery/{id}', [WeddingSection6GalleryController::class, 'destroy']);
});