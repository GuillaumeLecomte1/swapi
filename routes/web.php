<?php

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Documentation de l'API SWAPI",
 *      description="API pour interagir avec SWAPI (Star Wars API)",
 *      @OA\Contact(
 *          email="contact@example.com"
 *      )
 * )
 */

use Illuminate\Support\Facades\Route;
use OpenApi\Annotations as OA;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::redirect('/', 'api/documentation');

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
Route::get('/debug-sentry-testError', function () {
    throw new Exception('My second Sentry error :) !');
});