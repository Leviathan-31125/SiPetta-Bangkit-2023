<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\WebAdmin\NewsLetterController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('apps/dashboard');
});

Route::prefix('/apps')->group(function () {
    Route::get('/master-user', function () {
        return view('apps.masteruser');
    });
    Route::get('/master-menu', function () {
        return view('apps.mastermenu');
    });

    Route::controller(NewsLetterController::class)->prefix('/news-letter')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/list', 'getAllNewsLetter');
            Route::post('/', 'addNewsLetter');
            Route::delete('/{id}', 'deleteNewsLetter');
        });
});
