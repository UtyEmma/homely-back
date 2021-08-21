<?php

use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agent\AuthAgentController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Listings\ListingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WishList\WishlistController;
use App\Http\Controllers\Details\DetailController;
use App\Http\Controllers\Listings\Favourites\FavouritesController;
use App\Http\Controllers\Reviews\ReviewController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Support\ChatController;
use App\Http\Controllers\Support\SupportController;
use App\Models\Review;
use App\Models\Verification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('agent')->middleware('role:agent')->group(function(){
    
    Route::get('resend/{agent}', [AuthAgentController::class, 'resendVerificationLink']);
    Route::get('logout', [AuthAgentController::class, 'logout']);

    Route::middleware('verified.email:agent')->group(function(){
        
        Route::post('update', [AgentController::class, 'update']);
        Route::get('auth_user', [AgentController::class, 'getLoggedInUser']);
        Route::get('user/{user}', [AgentController::class, 'single']);

        Route::prefix('listing')->group(function(){
            Route::post('create', [ListingController::class, 'createListing']);
            Route::get('agents-listings', [ListingController::class, 'getAgentsListings']);
            Route::get('delete/{listing_id}', [ListingController::class, 'deleteListing']);
            Route::get('remove/{listing_id}', [ListingController::class, 'agentRemoveListing']);
        });

        Route::prefix('reviews')->group(function(){
            Route::get('/', [ReviewController::class, 'fetchAgentReviews']);
            Route::post('/report/{review_id}', [ReviewController::class, 'reportUser']);
        });

        Route::prefix('support')->group(function(){
            Route::post('/create', [SupportController::class, 'initiateNewIssue']);
            Route::get('/', [SupportController::class, 'fetchAgentTickets']);
            Route::get('/delete', [SupportController::class, 'deleteTicket']);
        });

        Route::prefix('chats')->group(function(){
            Route::post('/send', [ChatController::class, 'sendMessage']);
            Route::get('/{ticket_id}', [ChatController::class, 'fetchChats']);
        });

        Route::prefix('wishlists')->group(function(){
            Route::get('/', [AgentController::class, 'fetchAgentWishlists']);
        });

    });
    
});


Route::prefix('tenant')->middleware('role:tenant')->group(function(){
    
    Route::get('resend/{user}', [AuthUserController::class, 'resendVerificationLink']);

    Route::middleware('verified.email:tenant')->group(function(){
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

        Route::prefix('favourites')->group(function(){
            Route::get('add/{listing_id}', [FavouritesController::class, 'addToFavourites']);
            Route::get('remove/{listing_id}', [FavouritesController::class, 'removeFromFavourites']);
            Route::get('/', [FavouritesController::class, 'fetchFavourites']);
        });
    });

});

Route::prefix('tenant')->group(function(){
    Route::post('login', [AuthUserController::class, 'login'])->middleware('role:tenant');
    Route::post('signup', [AuthUserController::class, 'signup']);
    Route::post('forgot-password', [AuthUserController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthUserController::class, 'resetPassword']);
});

Route::prefix('agent')->group(function(){
    Route::post('login', [AuthAgentController::class, 'login']);
    Route::post('signup', [AuthAgentController::class, 'signup']);
    Route::get('all', [AgentController::class, 'show']);
    Route::get('/{slug}', [AgentController::class, 'single']);
    Route::post('forgot-password', [AuthAgentController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthAgentController::class, 'resetPassword']);
});

Route::prefix('listings')->middleware('role')->group(function(){
    Route::get('/', [ListingController::class, 'fetchListings']);
    Route::get('/popular', [ListingController::class, 'fetchPopularListings']);
    Route::get('/{slug}', [ListingController::class, 'getSingleListing']);
    Route::post('/search', [SearchController::class, 'searchListings']);
    Route::post('/update-views/{listing_id}', [ListingController::class, 'updateListingViews']);
});

Route::prefix('details')->group(function(){
    Route::get('/', [DetailController::class, 'fetchDetails']);
    Route::get('categories', [DetailController::class, 'fetchCategories']);
});

Route::prefix('reviews')->group(function(){
    Route::get('fetch/{listing_id}', [ReviewController::class, 'fetchListingReviews']);
});

Route::prefix('social')->group(function(){
    Route::post('auth', [SocialAuthController::class, 'handleAuth']);
});


