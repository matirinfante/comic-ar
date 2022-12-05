<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComictecaController;
use App\Http\Controllers\EditionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolumeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/volumes/lastest', [HomeController::class, 'lastest']);
Route::get('/volumes/popular', [HomeController::class, 'popular']);
Route::get('/users/{id}', [UserController::class, 'userInfo']);
Route::get('/editions/{id}', [EditionController::class, 'editionInfo']);
Route::post('/comicteca', [ComictecaController::class, 'addToComicteca']);
Route::get('/comicteca/{id}', [ComictecaController::class, 'comictecaUser']);
Route::get('/comicteca/stats/{id}', [ComictecaController::class, 'comictecaStats']);
Route::get('/comicteca/alreadyThere/{id}', [ComictecaController::class, 'checkAdded']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

