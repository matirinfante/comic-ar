<?php

use App\Http\Controllers\ComictecaController;
use App\Http\Controllers\ReviewController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    Route::resource('/editions', EditionController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/volumes', VolumeController::class);
    Route::resource('/reviews', ReviewController::class);
    Route::resource('/wishlists', WishlistController::class);
    Route::resource('/comictecas', ComictecaController::class);
    Route::get('/search', [EditionController::class, 'searchBy']);
    Route::get('/check-review', [ReviewController::class, 'checkReview']);
    Route::get('/edition-reviews', [ReviewController::class, 'showReviews']);
    Route::get('/edition-score', [ReviewController::class, 'scoreReviews']);
    Route::post('/comictecas-complete', [ComictecaController::class,'completeEdition']);
    Route::post('/comictecas.update', [ComictecaController::class,'update']);
});


Route::get('/apibooks', function () {
    return Inertia::render('googlebooks', []);
});

//Route::middleware(['auth:sanctum', 'verified'])->resource('/users',UserController::class);
