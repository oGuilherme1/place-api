<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Src\Place\Infra\Controllers\CreatePlace\CreatePlaceController;
use Src\Place\Infra\Controllers\GetAllPlace\GetAllPlaceController;
use Src\Place\Infra\Controllers\GetSpecificPlace\GetSpecificPlaceController;
use Src\Place\Infra\Controllers\UpdatePlace\UpdatePlaceController;

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

Route::post('place', [CreatePlaceController::class, 'execute']);
Route::put('place', [UpdatePlaceController::class, 'execute']);
Route::get('place/{name?}', [GetAllPlaceController::class, 'execute']);
Route::get('place/specific/{id}', [GetSpecificPlaceController::class, 'execute']);
