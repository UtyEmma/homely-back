<?php
namespace App\Http\Controllers\Listings\Favourites;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Listings\CompileListing;
use App\Models\Favourite;
use App\Models\Listing;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class FavouritesController extends Controller{
    use CompileListing;

    public function addToFavourites($listing_id){
        try {
            $user = auth()->user();

            if (!Listing::find($listing_id)) {
                throw new Exception("Property does not Exist", 404);
            }

            if (Favourite::where('listing_id', $listing_id)->where('user_id', $user->unique_id)->first()) {
                return $this->removeFromFavourites($listing_id);
            }

            $unique_id = $this->createUniqueToken('favourites', 'unique_id');

            Favourite::create([
                'unique_id' => $unique_id,
                'user_id' => $user->unique_id,
                'listing_id' => $listing_id
            ]);

            $user = User::find($user->unique_id);
            $user->no_favourites = $user->no_favourites + 1;
            $user->save();

            $favourites = User::find($user->unique_id)->favourites;
            $array = [];

            foreach ($favourites as $key => $favourite){
                $listing_id = $favourite->listing_id;
                $array[] = Listing::find($listing_id);
            }

            $listings = $this->formatListingData($array);

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Property added to your favourites", [
            'status' => true,
            'user' => User::find($user->unique_id)
        ]);
    }

    public function removeFromFavourites($listing_id){
        try {
            $user = auth()->user();
            if (!$favourite = Favourite::where('listing_id', $listing_id)->where('user_id', $user->unique_id)->first()) {
                return $this->addToFavourites($listing_id);
            }
            $favourite->delete();

            $user = User::find($user->unique_id);
            $user->no_favourites = $user->no_favourites - 1;
            $user->save();

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
        return $this->success("Property has been removed from your Favourites", [
            'listings' => $listings,
            'status' => false,
            'user' => User::find($user->unique_id)
        ]);
    }

    public function fetchFavourites(){
        try {
           $listings = $this->allFavourites();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Favourites Fetched", [
            'listings' => $listings
        ]);
    }

    public function allFavourites(){
        $user = auth()->user();
        $favourites = User::find($user->unique_id)->favourites;
        $array = [];

        if (count($favourites)) {
            foreach ($favourites as $key => $favourite){
                $listing_id = $favourite->listing_id;
                $array[] = Listing::find($listing_id);
            }
        }

        return $this->formatListingData($array, $user);
    }
}
