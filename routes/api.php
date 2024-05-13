<?php

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
Route::post('admin/login');
Route::get('profiles', [\App\Http\Controllers\Api\ProfileController::class, 'index']);

Route::middleware('auth:api')->group(function(){
    Route::post('profile/create');
    Route::post('profile/{id}/comment/create');
    Route::get('profile/{id}/comments');
    Route::put('profile/{id}/update/');
    Route::delete('profile/{id}/delete');
});

