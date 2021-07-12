<?php

use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CategoriesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', [AppController::class, 'login'])->name('login');
Route::get('register', [AppController::class, 'signup']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'signup']);

Route::middleware('auth')->group(function(){
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/', [AppController::class, 'dashboard']);
    
    Route::get('/tenants', [AppController::class, 'tenants']);

    Route::get('/agents', [AppController::class, 'agents']);

    Route::get('/listings', [AppController::class, 'listings']);

    Route::prefix('categories')->group(function(){
        Route::get('/', [AppController::class, 'categories']);
        Route::post('create', [CategoriesController::class, 'createCategory']);
    });
});


