<?php

namespace App\Http\Controllers\WishList;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wishlist\CreateWishlistRequest;
use App\Models\User;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function createWishlist(CreateWishlistRequest $request){
        try {
            $validated = $request->validated();
            $tenant = $this->tenant();
            $unique_id = $this->createUniqueToken('wishlists', 'unique_id');
            $features = json_encode($request->features);
            $amenities = json_encode($request->amenities);

            $new_wishlist = Wishlist::create(array_merge($validated, [
                'unique_id' => $unique_id,
                'user_id' => $tenant->unique_id,
                'features' => $features,
                'amenities' => $amenities,
                'budget' => $request->budget
            ]));

            // $this->sendWishlistNotification($new_wishlist);
            
            $user = User::find($tenant->unique_id);
            $user->wishlists = $user->wishlists + 1;
            $user->save();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success('Wishlist Item Added');
    }

    public function fetchTenantWishlist(){
        try {
            $tenant = $this->tenant();
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

    public function sendWishlistNotification($wishlist){
        // $agents = $query
    }

    
}
