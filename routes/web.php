<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\AppController;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\DetailController;
use App\Http\Controllers\Admin\ListingsController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Admin\SupportController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Admin\WishlistController;
use App\Models\Admin;
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
    Route::get('profile', [AppController::class, 'profile']);
    Route::post('update-profile', [AdminController::class, 'update']);
    Route::get('properties', [AppController::class, 'properties']);
    
    Route::prefix('tenants')->group(function(){
        Route::get('/', [AppController::class, 'tenants']);
        Route::get('/{id}', [TenantController::class, 'single']);
        Route::get('/delete/{id}', [TenantController::class, 'deleteTenant']);
        Route::get('/suspend/{id}', [TenantController::class, 'suspendTenant']);
    });

    Route::prefix('agents')->group(function(){
        Route::get('/', [AppController::class, 'agents']);
        Route::get('/{id}', [AgentController::class, 'single']);
        Route::get('/delete/{id}', [AgentController::class, 'deleteAgent']);
        Route::get('/suspend/{id}', [AgentController::class, 'suspendAgent']);
    });

    Route::prefix('listings')->group(function(){
        Route::get('/', [AppController::class, 'listings']);
        Route::get('/{id}', [ListingsController::class, 'single']);
        Route::get('/delete/{id}', [ListingsController::class, 'deleteListing']);
        Route::get('/suspend/{id}', [ListingsController::class, 'suspendListing']);
    });

    Route::prefix('categories')->group(function(){
        Route::post('create', [CategoriesController::class, 'createCategory']);
        Route::get('delete/{id}', [CategoriesController::class, 'deleteCategory']);
        Route::get('suspend/{id}', [CategoriesController::class, 'suspendCategory']);
    });

    Route::prefix('features')->group(function(){
        Route::post('create-features', [DetailController::class, 'createFeatures']);
        Route::get('delete/{id}', [DetailController::class, 'deleteFeatures']);
    });

    Route::prefix('amenities')->group(function(){
        Route::post('create-amenities', [DetailController::class, 'createAmenities']);
        Route::get('delete/{id}', [DetailController::class, 'deleteAmenities']);
    });

    Route::prefix('support')->group(function(){
        Route::get('/', [SupportController::class, 'fetchTickets']);
        Route::get('/{ticket_id}', [SupportController::class, 'singleTicket']);
        Route::get('/resolve', [SupportController::class, 'markTicketAsResolved']);
        Route::get('/delete', [SupportController::class, 'deleteTicket']);
        Route::post('/chat/{id}', [SupportController::class, 'sendMessage'] );
    });

    Route::prefix('reviews')->group(function(){
        Route::get('/', [ReviewsController::class, 'fetchReviews']);
        Route::get('/block/{id}', [ReviewsController::class, 'blockReviews']);
        Route::get('/delete/{id}', [ReviewsController::class, 'deleteReviews']);
    });

    Route::prefix('wishlists')->group(function(){
        Route::get('/', [WishlistController::class, 'fetchWishlists']);
        Route::get('/block/{id}', [WishlistController::class, 'blockWishlists']);
        Route::get('/delete/{id}', [WishlistController::class, 'deleteWishlists']);
    });

    Route::prefix('admins')->group(function(){
        Route::get('/', [AppController::class, 'admins']);
        Route::get('/delete/{id}', [AdminController::class, 'deleteAdmin']);
        Route::get('/suspend/{id}', [AdminController::class, 'suspendAdmin']);
        Route::get('/{id}', [AdminController::class, 'singleAdmin']);

    });
});



