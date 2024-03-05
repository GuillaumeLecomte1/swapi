<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PlanetsController;
use App\Http\Controllers\FilmsController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\VehiclesController;
use App\Http\Controllers\StarshipsController;
use App\Http\Controllers\LoginController;
use App\Http\Middleware\AuthJwt;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('status.euh')->get('/user', function (Request $request) {
    return $request->user();
});

// User routes
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/register', [LoginController::class, 'register'])->name('register');


Route::middleware([AuthJwt::class])->middleware('status.euh')->group(function(){

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // People routes
    Route::get('/people', [PeopleController::class, 'readAll']);
    Route::get('/people/{id}', [PeopleController::class, 'read']);
    Route::post('/people', [PeopleController::class, 'create']);
    Route::put('/people/{id}', [PeopleController::class, 'update']);
    Route::delete('/people/{id}', [PeopleController::class, 'destroy']);

    // Planets routes
    Route::get('/planets', [PlanetsController::class, 'readAll']);
    Route::get('/planets/{id}', [PlanetsController::class, 'read']);
    Route::post('/planets', [PlanetsController::class, 'create']);
    Route::put('/planets/{id}', [PlanetsController::class, 'update']);
    Route::delete('/planets/{id}', [PlanetsController::class, 'destroy']);

    // Films routes
    Route::get('/films', [FilmsController::class, 'readAll']);
    Route::get('/films/{id}', [FilmsController::class, 'read']);
    Route::post('/films', [FilmsController::class, 'create']);
    Route::put('/films/{id}', [FilmsController::class, 'update']);
    Route::delete('/films/{id}', [FilmsController::class, 'destroy']);

    // Species routes
    Route::get('/species', [SpeciesController::class, 'readAll']);
    Route::get('/species/{id}', [SpeciesController::class, 'read']);
    Route::post('/species', [SpeciesController::class, 'create']);
    Route::put('/species/{id}', [SpeciesController::class, 'update']);
    Route::delete('/species/{id}', [SpeciesController::class, 'destroy']);

    // Vehicles routes
    Route::get('/vehicles', [VehiclesController::class, 'readAll']);
    Route::get('/vehicles/{id}', [VehiclesController::class, 'read']);
    Route::post('/vehicles', [VehiclesController::class, 'create']);
    Route::put('/vehicles/{id}', [VehiclesController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehiclesController::class, 'destroy']);

    // Starships routes
    Route::get('/starships', [StarshipsController::class, 'readAll']);
    Route::get('/starships/{id}', [StarshipsController::class, 'read']);
    Route::post('/starships', [StarshipsController::class, 'create']);
    Route::put('/starships/{id}', [StarshipsController::class, 'update']);
    Route::delete('/starships/{id}', [StarshipsController::class, 'destroy']);


});