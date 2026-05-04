<?php

use Illuminate\Support\Facades\Route; // Import the Route facade
use App\Http\Controllers\WelcomeController; // Import the controller we will create

// When the user visits 'your-site.com/hello', use WelcomeController's 'index' method
Route::get('/hello', [WelcomeController::class, 'index']);