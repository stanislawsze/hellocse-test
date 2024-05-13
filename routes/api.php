<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ProfileController;
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
Route::post('admin/login', [AdminController::class, 'login']);
Route::get('profiles', [ProfileController::class, 'index']);

Route::middleware('auth.api')->group(function(){
    Route::post('profile/create', [ProfileController::class, 'create']);
    Route::post('profile/{id}/comment/create', [ProfileController::class, 'comment']);
    Route::put('profile/{id}/update', [ProfileController::class, 'update']);
    Route::delete('profile/{id}/delete', [ProfileController::class, 'delete']);
});

