<?php

namespace App\Http\Controllers\Listings\Favourites;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Listings\CompileListings;
use App\Models\Favourite;
use App\Models\Listing;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class FavouritesController extends Controller{
    use CompileListings;

    public function addToFavourites($listing_id){
        try {
            $user = auth()->user();

            if (!$listing = Listing::find($listing_id)) {
                throw new Exception("Property does not Exist", 404);
            }

            if (Favourite::where('listing_id', $listing_id)->where('user_id', $user->unique_id)->first()) {
                throw new Exception("This property is already added to your Favourites", 400);
            }

            $unique_id = $this->createUniqueToken('favourites', 'unique_id');

            Favourite::create([
                'unique_id' => $unique_id,
                'user_id' => $user->unique_id,
                'listing_id' => $listing_id
            ]);

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Property added to your favourites");
    }

    public function removeFromFavourites($listing_id){
        try {
            $user = auth()->user();
            if (!$favourite = Favourite::where('listing_id', $listing_id)->where('user_id', $user->unique_id)->first()) {
                throw new Exception("This property is not added to your Favourites", 400);
            }
            $favourite->delete();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        return $this->success("Property has been removed from your Favourites");
    }

    public function fetchFavourites($listing_id){
        try {
            $user = auth()->user();
            $favourites = User::find($user->unique_id)->favourites;
            $array = [];
            
            foreach ($favourites as $key => $favourite){
                $listing_id = $favourite->listing_id;
                $array[] = Listing::find($listing_id);
            }

            $listings = $this->formatListingData($array);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Favourites Fetched", [
            'listings' => $listings
        ]);
    }
}
