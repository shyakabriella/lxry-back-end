<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Controllers - Namespace Imports
|--------------------------------------------------------------------------
*/

// Authentication & Core
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\WelcomeSlideController;

// Home Page Sections
use App\Http\Controllers\API\HomeSectionOneController;
use App\Http\Controllers\API\HomePageSectionTwoController;
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

// Wedding Venues
use App\Http\Controllers\API\Wedding\Venues\WeddingVenuesHeroController;
use App\Http\Controllers\API\Wedding\Venues\WeddingVenuesSection1Controller;
use App\Http\Controllers\API\Wedding\Venues\WeddingVenuesSection2Controller;
use App\Http\Controllers\API\Wedding\Venues\WeddingVenuesSection3Controller;
use App\Http\Controllers\API\Wedding\Venues\WeddingVenuesSection4Controller;

// Wedding Services
use App\Http\Controllers\API\Wedding\Services\WeddingServicesHeroController;
use App\Http\Controllers\API\Wedding\Services\WeddingServicesSection1Controller;
use App\Http\Controllers\API\Wedding\Services\WeddingServicesSection2Controller;
use App\Http\Controllers\API\Wedding\Services\WeddingServicesSection3Controller;
use App\Http\Controllers\API\Wedding\Services\WeddingServicesSection4Controller;
use App\Http\Controllers\API\Wedding\Services\WeddingServicesSection5Controller;

// Wedding Services Simple CRUD
use App\Http\Controllers\API\Wedding\WeddingServiceController;

// Wedding Packages
use App\Http\Controllers\API\Wedding\Packages\WeddingPackagesHeroController;
use App\Http\Controllers\API\Wedding\Packages\WeddingPackagesSection1Controller;
use App\Http\Controllers\API\Wedding\Packages\WeddingPackagesSection2Controller;
use App\Http\Controllers\API\Wedding\Packages\WeddingPackagesSection3Controller;
use App\Http\Controllers\API\Wedding\Packages\WeddingPackagesSection4Controller;
use App\Http\Controllers\API\Wedding\Packages\WeddingPackagesSection5Controller;

// Wedding Room Blocks
use App\Http\Controllers\API\Wedding\RoomBlocks\WeddingRoomBlocksHeroController;
use App\Http\Controllers\API\Wedding\RoomBlocks\WeddingRoomBlocksSection1Controller;
use App\Http\Controllers\API\Wedding\RoomBlocks\WeddingRoomBlocksSection2Controller;
use App\Http\Controllers\API\Wedding\RoomBlocks\WeddingRoomBlocksSection3Controller;
use App\Http\Controllers\API\Wedding\RoomBlocks\WeddingRoomBlocksSection4Controller;
use App\Http\Controllers\API\Wedding\RoomBlocks\WeddingRoomBlocksSection5Controller;

// Wedding Gallery
use App\Http\Controllers\API\Wedding\Gallery\WeddingGalleryHeroController;
use App\Http\Controllers\API\Wedding\Gallery\WeddingGallerySection1Controller;
use App\Http\Controllers\API\Wedding\Gallery\WeddingGallerySection2Controller;

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

// Home Sections View Only
Route::get('/home-page-section-two', [HomePageSectionTwoController::class, 'index']);

Route::get('/home-section-threes', [HomeSectionThreeController::class, 'index']);
Route::get('/home-section-threes/{id}', [HomeSectionThreeController::class, 'show']);

Route::get('/home-section-fours', [HomeSectionFourController::class, 'index']);
Route::get('/home-section-fours/active', [HomeSectionFourController::class, 'active']);
Route::get('/home-section-fours/{id}', [HomeSectionFourController::class, 'show']);

Route::get('/home-section-fives', [HomeSectionFiveController::class, 'index']);
Route::get('/home-section-fives/active', [HomeSectionFiveController::class, 'active']);
Route::get('/home-section-fives/{id}', [HomeSectionFiveController::class, 'show']);

// Facility Sections View Only
Route::get('/section5/luxury', [Section5LuxuryController::class, 'getSection']);
Route::get('/section6/gallery', [Section6GalleryController::class, 'getActiveImages']);
Route::get('/section7/fitness', [Section7FitnessController::class, 'getSection']);
Route::get('/section8/parking', [Section8ParkingController::class, 'getSection']);
Route::get('/section9/restaurant-bar', [Section9RestaurantBarController::class, 'getSection']);
Route::get('/section10/sauna', [Section10SaunaController::class, 'getSection']);
Route::get('/section11/pool', [Section11PoolController::class, 'getSection']);
Route::get('/section12/family-kids', [Section12FamilyKidsController::class, 'getSection']);

// Massage & Spa Public
Route::get('/massage-spa', [MassageSpaController::class, 'index']);

// Wedding Slides Public
Route::get('/wedding/slides', [WeddingSlideController::class, 'getSlides']);

// Wedding Sections Public
Route::get('/wedding/section1/venue', [WeddingSection1VenueController::class, 'getSection']);
Route::get('/wedding/section2/easy-plan', [WeddingSection2EasyPlanController::class, 'getSection']);
Route::get('/wedding/section2/slides', [WeddingSection2EasyPlanController::class, 'getSlides']);
Route::get('/wedding/section3/apartment', [WeddingSection3ApartmentController::class, 'getSection']);
Route::get('/wedding/section4/accommodations', [WeddingSection4AccommodationController::class, 'getSection']);
Route::get('/wedding/section5/location', [WeddingSection5LocationController::class, 'getSection']);
Route::get('/wedding/section6/gallery', [WeddingSection6GalleryController::class, 'getGallery']);

// Wedding Services Public View Only
Route::get('/wedding/services', [WeddingServiceController::class, 'getServices']);

// =========================================================================
// WEDDING VENUES - PUBLIC ROUTES
// =========================================================================
Route::get('/wedding-venues/hero', [WeddingVenuesHeroController::class, 'getHero']);
Route::get('/wedding-venues/section1', [WeddingVenuesSection1Controller::class, 'getSection']);
Route::get('/wedding-venues/section2', [WeddingVenuesSection2Controller::class, 'getSection']);
Route::get('/wedding-venues/section3', [WeddingVenuesSection3Controller::class, 'getSection']);
Route::get('/wedding-venues/section4', [WeddingVenuesSection4Controller::class, 'getSection']);

// =========================================================================
// WEDDING SERVICES - PUBLIC ROUTES
// =========================================================================
Route::get('/wedding-services/hero', [WeddingServicesHeroController::class, 'getHero']);
Route::get('/wedding-services/section1', [WeddingServicesSection1Controller::class, 'getSection']);
Route::get('/wedding-services/section2', [WeddingServicesSection2Controller::class, 'getSection']);
Route::get('/wedding-services/section3', [WeddingServicesSection3Controller::class, 'getSection']);
Route::get('/wedding-services/section4', [WeddingServicesSection4Controller::class, 'getSection']);
Route::get('/wedding-services/section5', [WeddingServicesSection5Controller::class, 'getSection']);

// =========================================================================
// WEDDING PACKAGES - PUBLIC ROUTES
// =========================================================================
Route::get('/wedding-packages/hero', [WeddingPackagesHeroController::class, 'getHero']);
Route::get('/wedding-packages/section1', [WeddingPackagesSection1Controller::class, 'getSection']);
Route::get('/wedding-packages/section2', [WeddingPackagesSection2Controller::class, 'getSection']);
Route::get('/wedding-packages/section3', [WeddingPackagesSection3Controller::class, 'getSection']);
Route::get('/wedding-packages/section4', [WeddingPackagesSection4Controller::class, 'getSection']);
Route::get('/wedding-packages/section5', [WeddingPackagesSection5Controller::class, 'getSection']);

// =========================================================================
// WEDDING ROOM BLOCKS - PUBLIC ROUTES
// =========================================================================
Route::get('/wedding-room-blocks/hero', [WeddingRoomBlocksHeroController::class, 'getHero']);
Route::get('/wedding-room-blocks/section1', [WeddingRoomBlocksSection1Controller::class, 'getSection']);
Route::get('/wedding-room-blocks/section2', [WeddingRoomBlocksSection2Controller::class, 'getSection']);
Route::get('/wedding-room-blocks/section3', [WeddingRoomBlocksSection3Controller::class, 'getSection']);
Route::get('/wedding-room-blocks/section4', [WeddingRoomBlocksSection4Controller::class, 'getSection']);
Route::get('/wedding-room-blocks/section5', [WeddingRoomBlocksSection5Controller::class, 'getSection']);

// =========================================================================
// WEDDING GALLERY - PUBLIC ROUTES
// =========================================================================
Route::get('/wedding-gallery/hero', [WeddingGalleryHeroController::class, 'getHero']);
Route::get('/wedding-gallery/section1', [WeddingGallerySection1Controller::class, 'getSection']);
Route::get('/wedding-gallery/section2', [WeddingGallerySection2Controller::class, 'getSection']);

// =========================================================================
// RESTAURANT - PUBLIC ROUTES
// =========================================================================

// Restaurant Menu Categories Public
Route::get('/restaurant-menu-categories', [RestaurantMenuCategoryController::class, 'index']);
Route::get('/restaurant-menu-categories/active', [RestaurantMenuCategoryController::class, 'active']);
Route::get('/restaurant-menu-categories/{id}', [RestaurantMenuCategoryController::class, 'show']);

// Restaurant Menu Items Public
Route::get('/restaurant-menu-items', [RestaurantMenuItemController::class, 'index']);
Route::get('/restaurant-menu-items/active', [RestaurantMenuItemController::class, 'active']);
Route::get('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'show']);

// Restaurant Bookings Public
Route::post('/restaurant-bookings', [RestaurantBookingController::class, 'store']);

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
| Requires auth:sanctum middleware.
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

    // Restaurant Bar Section
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

    // Family Kids
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
    | Home Sections Management
    |--------------------------------------------------------------------------
    */
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
    | RESTAURANT MENU CATEGORIES MANAGEMENT (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::post('/restaurant-menu-categories', [RestaurantMenuCategoryController::class, 'store']);
    Route::put('/restaurant-menu-categories/{id}', [RestaurantMenuCategoryController::class, 'update']);
    Route::delete('/restaurant-menu-categories/{id}', [RestaurantMenuCategoryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | RESTAURANT MENU ITEMS MANAGEMENT (ADMIN)
    |--------------------------------------------------------------------------
    */
    Route::post('/restaurant-menu-items', [RestaurantMenuItemController::class, 'store']);
    Route::put('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);
    Route::post('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'update']);
    Route::delete('/restaurant-menu-items/{id}', [RestaurantMenuItemController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | RESTAURANT BOOKING MANAGEMENT (ADMIN)
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
    | Wedding Sections Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/section1/venue', [WeddingSection1VenueController::class, 'store']);
    Route::put('/admin/wedding/section1/venue/{id}', [WeddingSection1VenueController::class, 'update']);
    Route::delete('/admin/wedding/section1/venue/{id}', [WeddingSection1VenueController::class, 'destroy']);

    Route::post('/admin/wedding/section2/easy-plan', [WeddingSection2EasyPlanController::class, 'store']);
    Route::put('/admin/wedding/section2/easy-plan/{id}', [WeddingSection2EasyPlanController::class, 'update']);
    Route::delete('/admin/wedding/section2/easy-plan/{id}', [WeddingSection2EasyPlanController::class, 'destroy']);

    Route::post('/admin/wedding/section2/slides', [WeddingSection2EasyPlanController::class, 'store']);
    Route::post('/admin/wedding/section2/slides/{id}', [WeddingSection2EasyPlanController::class, 'update']);
    Route::delete('/admin/wedding/section2/slides/{id}', [WeddingSection2EasyPlanController::class, 'destroy']);
    Route::get('/admin/wedding/section2/slides', [WeddingSection2EasyPlanController::class, 'index']);

    Route::post('/admin/wedding/section3/apartment', [WeddingSection3ApartmentController::class, 'store']);
    Route::put('/admin/wedding/section3/apartment/{id}', [WeddingSection3ApartmentController::class, 'update']);
    Route::delete('/admin/wedding/section3/apartment/{id}', [WeddingSection3ApartmentController::class, 'destroy']);

    Route::post('/admin/wedding/section4/accommodations', [WeddingSection4AccommodationController::class, 'store']);
    Route::put('/admin/wedding/section4/accommodations/{id}', [WeddingSection4AccommodationController::class, 'update']);
    Route::delete('/admin/wedding/section4/accommodations/{id}', [WeddingSection4AccommodationController::class, 'destroy']);

    Route::post('/admin/wedding/section5/location', [WeddingSection5LocationController::class, 'store']);
    Route::put('/admin/wedding/section5/location/{id}', [WeddingSection5LocationController::class, 'update']);
    Route::delete('/admin/wedding/section5/location/{id}', [WeddingSection5LocationController::class, 'destroy']);

    Route::post('/admin/wedding/section6/gallery', [WeddingSection6GalleryController::class, 'store']);
    Route::put('/admin/wedding/section6/gallery/{id}', [WeddingSection6GalleryController::class, 'update']);
    Route::delete('/admin/wedding/section6/gallery/{id}', [WeddingSection6GalleryController::class, 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Wedding Services Management
    |--------------------------------------------------------------------------
    */
    Route::post('/admin/wedding/services', [WeddingServiceController::class, 'store']);
    Route::put('/admin/wedding/services/{id}', [WeddingServiceController::class, 'update']);
    Route::delete('/admin/wedding/services/{id}', [WeddingServiceController::class, 'destroy']);

    // =========================================================================
    // WEDDING VENUES - ADMIN ROUTES
    // =========================================================================
    Route::post('/admin/wedding-venues/hero', [WeddingVenuesHeroController::class, 'store']);
    Route::put('/admin/wedding-venues/hero/{id}', [WeddingVenuesHeroController::class, 'update']);
    Route::delete('/admin/wedding-venues/hero/{id}', [WeddingVenuesHeroController::class, 'destroy']);

    Route::post('/admin/wedding-venues/section1', [WeddingVenuesSection1Controller::class, 'store']);
    Route::put('/admin/wedding-venues/section1/{id}', [WeddingVenuesSection1Controller::class, 'update']);
    Route::delete('/admin/wedding-venues/section1/{id}', [WeddingVenuesSection1Controller::class, 'destroy']);

    Route::post('/admin/wedding-venues/section2', [WeddingVenuesSection2Controller::class, 'store']);
    Route::put('/admin/wedding-venues/section2/{id}', [WeddingVenuesSection2Controller::class, 'update']);
    Route::delete('/admin/wedding-venues/section2/{id}', [WeddingVenuesSection2Controller::class, 'destroy']);

    Route::post('/admin/wedding-venues/section3', [WeddingVenuesSection3Controller::class, 'store']);
    Route::put('/admin/wedding-venues/section3/{id}', [WeddingVenuesSection3Controller::class, 'update']);
    Route::delete('/admin/wedding-venues/section3/{id}', [WeddingVenuesSection3Controller::class, 'destroy']);

    Route::post('/admin/wedding-venues/section4', [WeddingVenuesSection4Controller::class, 'store']);
    Route::put('/admin/wedding-venues/section4/{id}', [WeddingVenuesSection4Controller::class, 'update']);
    Route::delete('/admin/wedding-venues/section4/{id}', [WeddingVenuesSection4Controller::class, 'destroy']);

    // =========================================================================
    // WEDDING SERVICES - ADMIN ROUTES
    // =========================================================================
    Route::post('/admin/wedding-services/hero', [WeddingServicesHeroController::class, 'store']);
    Route::put('/admin/wedding-services/hero/{id}', [WeddingServicesHeroController::class, 'update']);
    Route::delete('/admin/wedding-services/hero/{id}', [WeddingServicesHeroController::class, 'destroy']);

    Route::post('/admin/wedding-services/section1', [WeddingServicesSection1Controller::class, 'store']);
    Route::put('/admin/wedding-services/section1/{id}', [WeddingServicesSection1Controller::class, 'update']);
    Route::delete('/admin/wedding-services/section1/{id}', [WeddingServicesSection1Controller::class, 'destroy']);

    Route::post('/admin/wedding-services/section2', [WeddingServicesSection2Controller::class, 'store']);
    Route::put('/admin/wedding-services/section2/{id}', [WeddingServicesSection2Controller::class, 'update']);
    Route::delete('/admin/wedding-services/section2/{id}', [WeddingServicesSection2Controller::class, 'destroy']);

    Route::post('/admin/wedding-services/section3', [WeddingServicesSection3Controller::class, 'store']);
    Route::put('/admin/wedding-services/section3/{id}', [WeddingServicesSection3Controller::class, 'update']);
    Route::delete('/admin/wedding-services/section3/{id}', [WeddingServicesSection3Controller::class, 'destroy']);

    Route::post('/admin/wedding-services/section4', [WeddingServicesSection4Controller::class, 'store']);
    Route::put('/admin/wedding-services/section4/{id}', [WeddingServicesSection4Controller::class, 'update']);
    Route::delete('/admin/wedding-services/section4/{id}', [WeddingServicesSection4Controller::class, 'destroy']);

    Route::post('/admin/wedding-services/section5', [WeddingServicesSection5Controller::class, 'store']);
    Route::put('/admin/wedding-services/section5/{id}', [WeddingServicesSection5Controller::class, 'update']);
    Route::delete('/admin/wedding-services/section5/{id}', [WeddingServicesSection5Controller::class, 'destroy']);

    // =========================================================================
    // WEDDING PACKAGES - ADMIN ROUTES
    // =========================================================================
    Route::post('/admin/wedding-packages/hero', [WeddingPackagesHeroController::class, 'store']);
    Route::put('/admin/wedding-packages/hero/{id}', [WeddingPackagesHeroController::class, 'update']);
    Route::delete('/admin/wedding-packages/hero/{id}', [WeddingPackagesHeroController::class, 'destroy']);

    Route::post('/admin/wedding-packages/section1', [WeddingPackagesSection1Controller::class, 'store']);
    Route::put('/admin/wedding-packages/section1/{id}', [WeddingPackagesSection1Controller::class, 'update']);
    Route::delete('/admin/wedding-packages/section1/{id}', [WeddingPackagesSection1Controller::class, 'destroy']);

    Route::post('/admin/wedding-packages/section2', [WeddingPackagesSection2Controller::class, 'store']);
    Route::put('/admin/wedding-packages/section2/{id}', [WeddingPackagesSection2Controller::class, 'update']);
    Route::delete('/admin/wedding-packages/section2/{id}', [WeddingPackagesSection2Controller::class, 'destroy']);

    Route::post('/admin/wedding-packages/section3', [WeddingPackagesSection3Controller::class, 'store']);
    Route::put('/admin/wedding-packages/section3/{id}', [WeddingPackagesSection3Controller::class, 'update']);
    Route::delete('/admin/wedding-packages/section3/{id}', [WeddingPackagesSection3Controller::class, 'destroy']);

    Route::post('/admin/wedding-packages/section4', [WeddingPackagesSection4Controller::class, 'store']);
    Route::put('/admin/wedding-packages/section4/{id}', [WeddingPackagesSection4Controller::class, 'update']);
    Route::delete('/admin/wedding-packages/section4/{id}', [WeddingPackagesSection4Controller::class, 'destroy']);

    Route::post('/admin/wedding-packages/section5', [WeddingPackagesSection5Controller::class, 'store']);
    Route::put('/admin/wedding-packages/section5/{id}', [WeddingPackagesSection5Controller::class, 'update']);
    Route::delete('/admin/wedding-packages/section5/{id}', [WeddingPackagesSection5Controller::class, 'destroy']);

    // =========================================================================
    // WEDDING ROOM BLOCKS - ADMIN ROUTES
    // =========================================================================
    Route::post('/admin/wedding-room-blocks/hero', [WeddingRoomBlocksHeroController::class, 'store']);
    Route::put('/admin/wedding-room-blocks/hero/{id}', [WeddingRoomBlocksHeroController::class, 'update']);
    Route::delete('/admin/wedding-room-blocks/hero/{id}', [WeddingRoomBlocksHeroController::class, 'destroy']);

    Route::post('/admin/wedding-room-blocks/section1', [WeddingRoomBlocksSection1Controller::class, 'store']);
    Route::put('/admin/wedding-room-blocks/section1/{id}', [WeddingRoomBlocksSection1Controller::class, 'update']);
    Route::delete('/admin/wedding-room-blocks/section1/{id}', [WeddingRoomBlocksSection1Controller::class, 'destroy']);

    Route::post('/admin/wedding-room-blocks/section2', [WeddingRoomBlocksSection2Controller::class, 'store']);
    Route::put('/admin/wedding-room-blocks/section2/{id}', [WeddingRoomBlocksSection2Controller::class, 'update']);
    Route::delete('/admin/wedding-room-blocks/section2/{id}', [WeddingRoomBlocksSection2Controller::class, 'destroy']);

    Route::post('/admin/wedding-room-blocks/section3', [WeddingRoomBlocksSection3Controller::class, 'store']);
    Route::put('/admin/wedding-room-blocks/section3/{id}', [WeddingRoomBlocksSection3Controller::class, 'update']);
    Route::delete('/admin/wedding-room-blocks/section3/{id}', [WeddingRoomBlocksSection3Controller::class, 'destroy']);

    Route::post('/admin/wedding-room-blocks/section4', [WeddingRoomBlocksSection4Controller::class, 'store']);
    Route::put('/admin/wedding-room-blocks/section4/{id}', [WeddingRoomBlocksSection4Controller::class, 'update']);
    Route::delete('/admin/wedding-room-blocks/section4/{id}', [WeddingRoomBlocksSection4Controller::class, 'destroy']);

    Route::post('/admin/wedding-room-blocks/section5', [WeddingRoomBlocksSection5Controller::class, 'store']);
    Route::put('/admin/wedding-room-blocks/section5/{id}', [WeddingRoomBlocksSection5Controller::class, 'update']);
    Route::delete('/admin/wedding-room-blocks/section5/{id}', [WeddingRoomBlocksSection5Controller::class, 'destroy']);

    // =========================================================================
    // WEDDING GALLERY - ADMIN ROUTES
    // =========================================================================
    Route::post('/admin/wedding-gallery/hero', [WeddingGalleryHeroController::class, 'store']);
    Route::put('/admin/wedding-gallery/hero/{id}', [WeddingGalleryHeroController::class, 'update']);
    Route::delete('/admin/wedding-gallery/hero/{id}', [WeddingGalleryHeroController::class, 'destroy']);

    Route::post('/admin/wedding-gallery/section1', [WeddingGallerySection1Controller::class, 'store']);
    Route::put('/admin/wedding-gallery/section1/{id}', [WeddingGallerySection1Controller::class, 'update']);
    Route::delete('/admin/wedding-gallery/section1/{id}', [WeddingGallerySection1Controller::class, 'destroy']);

    Route::post('/admin/wedding-gallery/section2', [WeddingGallerySection2Controller::class, 'store']);
    Route::put('/admin/wedding-gallery/section2/{id}', [WeddingGallerySection2Controller::class, 'update']);
    Route::delete('/admin/wedding-gallery/section2/{id}', [WeddingGallerySection2Controller::class, 'destroy']);
});