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
use Illuminate\Support\Facades\Artisan;
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
Route::prefix('action')->group(function(){
    Route::get('default-admin', function(){
        Artisan::call('seed:admin');
        return redirect('login')->with('success', "Default Admin Created Please Login");
    });

    Route::get('/config-clear', function() {
        Artisan::call('config:clear');
        return '<code>Configurations cleared</code>';
    });

    Route::get('/cache-clear', function() {
        Artisan::call('cache:clear');
        return '<code>Cache cleared</code>';
    });

    Route::get('/config-cache', function() {
        Artisan::call('config:Cache');
        return '<code>Configurations cache cleared</code>';
    });

    Route::get('/migrate', function() {
        Artisan::call('migrate');
        return '<code>Database Migrated</code>';
    });

    Route::get('/clear-db', function() {
        Artisan::call('migrate:fresh');
        return '<code>Database cleared Successfully</code>';
    });
});

Route::get('login', [AppController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function(){
    Route::get('register', [AppController::class, 'signup']);
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'signup']);
    Route::get('/', [AppController::class, 'dashboard']);
    Route::get('profile', [AppController::class, 'profile']);
    Route::post('update-profile', [AdminController::class, 'update']);
    Route::post('update-password', [AdminController::class, 'updatePassword']);
    Route::get('properties', [AppController::class, 'properties']);

    Route::prefix('tenants')->group(function(){
        Route::get('/', [AppController::class, 'tenants']);
        Route::get('/{id}', [TenantController::class, 'single']);
        Route::get('/delete/{id}', [TenantController::class, 'deleteTenant']);
        Route::get('/suspend/{id}', [TenantController::class, 'suspendTenant']);
        Route::post('/search', [TenantController::class, 'searchForTenant']);
    });

    Route::prefix('agents')->group(function(){
        Route::get('/', [AppController::class, 'agents']);
        Route::get('/{id}', [AgentController::class, 'single']);
        Route::get('/delete/{id}', [AgentController::class, 'deleteAgent']);
        Route::get('/suspend/{id}', [AgentController::class, 'suspendAgent']);
        Route::get('/verify/{id}', [AgentController::class, 'verifyAgent']);
        Route::get('/confirm-email/{id}', [AgentController::class, 'confirmAgentEmail']);
        Route::post('/search', [TenantController::class, 'searchForAgent']);
    });

    Route::prefix('listings')->group(function(){
        Route::get('/', [AppController::class, 'listings']);
        Route::get('/{id}', [ListingsController::class, 'single']);
        Route::get('/delete/{id}', [ListingsController::class, 'deleteListing']);
        Route::get('/suspend/{id}', [ListingsController::class, 'suspendListing'])->middleware('can:makeChanges');
        Route::get('/confirm/{id}', [ListingsController::class, 'approveListing']);
        Route::post('/search', [TenantController::class, 'searchForListings']);
    });

    Route::prefix('categories')->group(function(){
        Route::post('create', [CategoriesController::class, 'createCategory']);
        Route::get('delete/{id}', [CategoriesController::class, 'deleteCategory']);
        Route::get('suspend/{id}', [CategoriesController::class, 'suspendCategory']);
        Route::post('edit/{id}', [CategoriesController::class, 'updateCategory']);
    });

    Route::prefix('features')->group(function(){
        Route::post('create-features', [DetailController::class, 'createFeatures']);
        Route::get('delete/{id}', [DetailController::class, 'deleteFeatures']);
    });

    Route::prefix('amenities')->group(function(){
        Route::post('create-amenities', [DetailController::class, 'createAmenities']);
        Route::get('delete/{id}', [DetailController::class, 'deleteAmenity']);
        Route::post('edit/{id}', [DetailController::class, 'updateAmenity']);
        Route::get('suspend/{id}', [DetailController::class, 'suspendAmenity']);
    });

    Route::prefix('support')->group(function(){
        Route::get('/', [SupportController::class, 'fetchTickets']);
        Route::get('ticket/{ticket_id}', [SupportController::class, 'singleTicket']);
        Route::get('/resolve/{ticket_id}', [SupportController::class, 'markTicketAsResolved']);
        Route::get('/delete', [SupportController::class, 'deleteTicket']);
        Route::post('/chat/{id}', [SupportController::class, 'sendMessage'] );
        Route::get('/pending', [SupportController::class, 'pendingTickets']);
        Route::get('/resolved', [SupportController::class, 'resolvedTickets']);
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



