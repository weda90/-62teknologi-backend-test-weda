<?php

use App\Http\Controllers\API\BusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {

    // Get Search business
    Route::get('/business/search', [BusinessController::class, 'search']);


    // Get a single business
    Route::get('/business/{id}', [BusinessController::class, 'show']);

    // Create a new business
    Route::post('/business', [BusinessController::class, 'store']);

    // Update a business
    Route::put('/business/{id}', [BusinessController::class, 'update']);

    // Delete a business
    Route::delete('/business/{id}', [BusinessController::class, 'destroy']);
});
