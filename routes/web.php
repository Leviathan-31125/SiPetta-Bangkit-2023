<?php

use App\Http\Controllers\WebAdmin\AgriFarmController;
use App\Http\Controllers\WebAdmin\AuthWebAdminController;
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
})->name('login');

Route::controller(AuthWebAdminController::class)->group(function () {
    Route::get('/login', 'login')->name('webLogin');
    Route::post('/authentication', 'authentication')->name('authentication');
});

Route::middleware(['auth', 'authwebadmin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('apps/dashboard');
    })->name('dashboard');

    Route::post('/logout', [AuthWebAdminController::class, 'logout'])
        ->name('logout');

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
                Route::get('/category', 'getAllCategory');
                Route::get('/{id}', 'getDetailNewsLetter');
                Route::put('/{id}', 'updateNewsLetter');
                Route::post('/', 'addNewsLetter');
                Route::delete('/{id}', 'deleteNewsLetter');
            });

        Route::controller(AgriFarmController::class)->prefix('/agri-farm')
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/list', 'getAllAgriFarm');
                Route::get('/{id}', 'getDetailAgriFarm');
                Route::put('/{id}', 'updateAgriFarm');
                Route::post('/', 'addAgriFarm');
                Route::delete('/{id}', 'deleteAgriFarm');
            });
    });
});
