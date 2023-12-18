<?php

use App\Http\Controllers\Api\FarmIssueController;
use App\Http\Controllers\Api\FormFarmIssueController;
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

Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
Route::get('/unAuthenticated', [\App\Http\Controllers\Api\AuthController::class, 'unAuthenticated'])->name('apiLogin');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/user', [\App\Http\Controllers\Api\AuthController::class, 'detail']);

    Route::controller(FormFarmIssueController::class)->prefix('/form-farm-issue')->group(function () {
        Route::get('/', 'getAllAgriFarm');
        Route::get('/{id}', 'getDetailAgriFarm');
        Route::get('/question/{agriCode}', 'getQuestion');
    });

    Route::controller(FarmIssueController::class)->prefix('/farm-issue')->group(function () {
        Route::get('/', 'getAllFarmIssue');
        Route::get('/{id}', 'getDetailFarmIssue');
        Route::post('/', 'addFarmIssue');
        Route::post('/{id}', 'updateFarmIssue');
        Route::post('/reply/{id}', 'replyFarmIssue');
        Route::delete('/{id}', 'deleteFarmIssue');
    });
});
