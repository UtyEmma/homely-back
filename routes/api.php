<?php

use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Agent\AuthAgentController;
use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\Listings\ListingController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\WishList\WishlistController;
use App\Http\Controllers\Details\DetailController;
use App\Http\Controllers\Email\VerificationController;
use App\Http\Controllers\Listings\Favourites\FavouritesController;
use App\Http\Controllers\Notification\NotificationController;
use App\Http\Controllers\Password\PasswordController;
use App\Http\Controllers\Reviews\ReviewController;
use App\Http\Controllers\Search\SearchController;
use App\Http\Controllers\Support\ChatController;
use App\Http\Controllers\Support\SupportController;
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
    Route::post('forgot-password', [AuthUserController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthUserController::class, 'resetPassword']);
    Route::get('/user', [AuthAgentController::class, 'getLoggedInUser']);

    Route::middleware('verified.email:agent')->group(function(){

        Route::post('update', [AgentController::class, 'update']);
        Route::get('user/{user}', [AgentController::class, 'single']);
        Route::get('unavailable', [AgentController::class, 'setStatusToUnavailable']);

        Route::prefix('listing')->group(function(){
            Route::post('create', [ListingController::class, 'createListing']);
            Route::get('agents-listings', [ListingController::class, 'getAgentsListings']);
            Route::post('update/{listing_id}', [ListingController::class, 'updateListing']);
            Route::get('delete/{listing_id}', [ListingController::class, 'deleteListing']);
            Route::get('remove/{listing_id}', [ListingController::class, 'agentRemoveListing']);
            Route::get('rented/{listing_id}', [ListingController::class, 'setListingAsRented']);
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

        Route::prefix('notifications')->group(function(){
            Route::get('/', [NotificationController::class, 'fetchNotifications']);
            Route::get('/markasread', [NotificationController::class, 'markAsRead']);
        });

    });

});


Route::prefix('tenant')->middleware('role:tenant')->group(function(){

    Route::get('resend/{user}', [AuthUserController::class, 'resendVerificationLink']);
    Route::get('/user', [AuthUserController::class, 'getLoggedInUser']);

    Route::middleware('verified.email:tenant')->group(function(){
        Route::get('logout', [AuthUserController::class, 'logout']);
        Route::post('update', [UserController::class, 'update']);
        Route::get('auth_user', [UserController::class, 'getLoggedInUser']);
        Route::get('user/{user}', [UserController::class, 'show']);

        Route::prefix('wishlist')->group(function(){
            Route::post('create', [WishlistController::class, 'createWishlist']);
            Route::get('get-wishlist', [WishlistController::class, 'fetchTenantWishlist']);
            Route::get('delete/{id}', [WishlistController::class, 'deleteWishlist']);

        });

        Route::prefix('reviews')->group(function(){
            Route::post('create/{listing_id}', [ReviewController::class, 'createReview']);
            Route::post('edit', [ReviewController::class, 'updateReview']);
            Route::get('delete/{review_id}', [ReviewController::class, 'deleteReview']);
        });

        Route::prefix('favourites')->group(function(){
            Route::get('add/{listing_id}', [FavouritesController::class, 'addToFavourites']);
            Route::get('remove/{listing_id}', [FavouritesController::class, 'removeFromFavourites']);
            Route::get('/', [FavouritesController::class, 'fetchFavourites']);
        });
    });
});

Route::get('admin/verify/{id}', [AdminController::class, 'verifyAdmin']);

Route::prefix('admin')->middleware('admin')->group(function(){
    Route::prefix('listing')->group(function(){
        Route::get('suspend/{id}', [ListingController::class, 'adminSuspendListing']);
        Route::get('delete/{id}', [AdminController::class, 'adminDeleteListing']);
    });
    Route::prefix('agent')->group(function(){
        Route::get('suspend/{id}', [AgentController::class, 'adminSuspendAgent']);
        Route::get('delete/{id}', [AdminController::class, 'adminDeleteAgent']);
        Route::get('verify/{id}', [AgentController::class, 'adminVerifyAgent']);
    });
});

Route::prefix('tenant')->group(function(){
    Route::post('login', [AuthUserController::class, 'login'])->middleware('role:tenant');
    Route::post('signup', [AuthUserController::class, 'signup']);
});

Route::prefix('agent')->group(function(){
    Route::post('login', [AuthAgentController::class, 'login'])->middleware('role:agent');
    Route::post('signup', [AuthAgentController::class, 'signup']);
    Route::get('all', [AgentController::class, 'show']);
    Route::get('/{slug}', [AgentController::class, 'single']);
    Route::post('forgot-password', [AuthAgentController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthAgentController::class, 'resetPassword']);
});

Route::prefix('listings')->middleware('role')->group(function(){
    Route::get('/', [ListingController::class, 'fetchListings']);
    Route::get('/popular', [ListingController::class, 'fetchPopularListings']);
    Route::get('/{username}/{slug}', [ListingController::class, 'getSingleListing']);
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

Route::prefix('auth')->group(function(){
    Route::post('reset-password', [PasswordController::class, 'resetPassword']);
    Route::post('recover-password', [PasswordController::class, 'recoverPassword']);
    Route::get('email/verify/{code}', [VerificationController::class, 'verify_email']);
});


