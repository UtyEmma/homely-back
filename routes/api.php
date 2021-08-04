<?php

use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agent\AuthAgentController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Listings\ListingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WishList\WishlistController;
use App\Http\Controllers\Details\DetailController;
use App\Http\Controllers\Reviews\ReviewController;
use App\Models\Verification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('tenant')->group(function(){
    Route::post('login', [AuthUserController::class, 'login']);
    Route::post('signup', [AuthUserController::class, 'signup']);
});

Route::prefix('agent')->group(function(){
    Route::post('login', [AuthAgentController::class, 'login']);
    Route::post('signup', [AuthAgentController::class, 'signup']);
    Route::get('all', [AgentController::class, 'show']);
    Route::get('/{slug}', [AgentController::class, 'show']);
});

Route::prefix('listings')->group(function(){
    Route::get('/', [ListingController::class, 'fetchAll']);
    Route::get('/active', [ListingController::class, 'getActiveListings']);
    Route::get('/{slug}', [ListingController::class, 'getSingleListing']);
});

Route::prefix('details')->group(function(){
    Route::get('/', [DetailController::class, 'fetchDetails']);
    Route::get('categories', [DetailController::class, 'fetchCategories']);
});


Route::prefix('agent')->group(function(){
    
    Route::get('resend/{agent}', [AuthAgentController::class, 'resendVerificationLink']);

    // Route::middleware('verified.email')->group(function(){

        Route::post('update', [AgentController::class, 'update']);
        Route::get('auth_user', [AgentController::class, 'getLoggedInUser']);
        Route::get('user/{user}', [AgentController::class, 'single']);
        Route::get('logout', [AuthAgentController::class, 'logout']);

        Route::prefix('listing')->group(function(){
            Route::post('create', [ListingController::class, 'createListing']);
            Route::get('agents-listings', [ListingController::class, 'getAgentsListings']);
            Route::get('delete/{listing_id}', [ListingController::class, 'deleteListing']);
            Route::get('remove/{listing_id}', [ListingController::class, 'agentRemoveListing']);
        });

    // });
});


Route::prefix('tenant')->middleware('api')->group(function(){

    Route::get('resend/{user}', [AuthUserController::class, 'resendVerificationLink']);

    Route::middleware('verified.email')->group(function(){
        Route::post('logout', [AuthUserController::class, 'logout']);
        Route::post('update', [UserController::class, 'update']);
        Route::get('auth_user', [UserController::class, 'getLoggedInUser']);
        Route::get('user/{user}', [UserController::class, 'show']);

        Route::prefix('wishlist')->group(function(){
            Route::post('create', [WishlistController::class, 'createWishlist']);
            Route::get('get-wishlist', [WishlistController::class, 'fetchTenantWishlist']);
        });

        Route::prefix('reviews')->group(function(){
            Route::post('create/{listing_id}', [ReviewController::class, 'createReview']);
        });
    });

});


