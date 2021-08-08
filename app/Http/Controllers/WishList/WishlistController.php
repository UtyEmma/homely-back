<?php

namespace App\Http\Controllers\WishList;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\CreateWishlistRequest;
use App\Models\User;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Wishlist\WishlistNotificationHandler;

class WishlistController extends Controller
{
    use WishlistNotificationHandler;

    public function createWishlist(CreateWishlistRequest $request){
        try {
            $validated = $request->validated();
            $tenant = auth()->user();
            $unique_id = $this->createUniqueToken('wishlists', 'unique_id');
            $amenities = json_encode($request->amenities);

            $new_wishlist = Wishlist::create(array_merge($request->all(), [
                'unique_id' => $unique_id,
                'user_id' => $tenant->unique_id,
                'amenities' => $amenities,
                'budget' => $request->budget
            ]));

            $user = User::find($tenant->unique_id);
            $user->wishlists = $user->wishlists + 1;
            $user->save();


            $wishlist = Wishlist::find($unique_id);
            $this->sendWishlistToAgents($wishlist);

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success('Wishlist Item Added', [
            'wishlist' => $wishlist
        ]);
    }

    public function fetchTenantWishlist(){
        try {
            $tenant = auth()->user();
            $wishlists = Wishlist::where('user_id', $tenant->unique_id)->get();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Wishlists Fetched", [
            'wishlists' => $wishlists,
            'no_of_wishlists' => count($wishlists)
        ]);
    }

    public function fetchAllWishlists(){
        try {
            return Wishlist::all();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function fetchAgentWishlist(){
        
        try {
            $agent = auth()->user();
            $wishlist = Wishlist::where('city', $agent->city)->where('status', true)->get();
            
            count($wishlist) < 20 && $wishlist = array_merge($wishlist, Wishlist::where('state', $agent->state)->where('status', true)->get());

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Agent Wishlist Fetched", [
            'wishlists' =>$wishlist
        ]);

    }

    
}
