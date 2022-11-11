<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\VolumeController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\ObjnotificationController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ComictecaController;
use App\Http\Controllers\BooklistController;
use App\Http\Controllers\SubscriptionController;

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
    Route::resource('/objectives', ObjectiveController::class);
    Route::resource('/objnotifications', ObjnotificationController::class);
    Route::resource('/artworks', ArtworkController::class);
    Route::resource('/booklists', BooklistController::class);
    Route::get('/search', [EditionController::class, 'searchBy']);
    Route::get('/check-review', [ReviewController::class, 'checkReview']);
    Route::get('/edition-reviews', [ReviewController::class, 'showReviews']);
    Route::get('/edition-score', [ReviewController::class, 'scoreReviews']);
    Route::post('/comictecas-complete', [ComictecaController::class, 'completeEdition']);
    Route::post('/comictecas.update', [ComictecaController::class, 'update']);
    Route::get('/searchObj', [ObjectiveController::class, 'searchBy']);
    Route::get('/objectives-show', [ObjectiveController::class, 'show']);
    Route::post('/objectives-update', [ObjectiveController::class, 'update']);
    Route::post('/objectives-calculate', [ObjectiveController::class, 'calculateProgress']);
    Route::get('/objnotifications-ask', [ObjnotificationController::class, 'ask']);
    Route::get('/objnotifications-update', [ObjnotificationController::class, 'update']);
    Route::get('/searchList', [BooklistController::class, 'searchBy']);
    Route::get('/searchVol', [VolumeController::class, 'searchBy']);
    Route::get('/characters', [EditionController::class, 'getCharactersFromAPI']);
    Route::get('/checkISBN', [EditionController::class, 'checkISBN']);
    Route::post('/edition-subscription', [SubscriptionController::class, 'editionSubscription']);
    Route::post('/edition-unsubscription', [SubscriptionController::class, 'editionUnsubscription']);
    Route::post('/edition-news-mail', [EditionController::class, 'editionNewsMail']);

    Route::get('/apibooks', function () {
        return Inertia::render('googlebooks', []);
    });
});

Route::get('/translate', [VolumeController::class, 'translate']);

//Route::middleware(['auth:sanctum', 'verified'])->resource('/users',UserController::class);
