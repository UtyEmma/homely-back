<?php

namespace App\Http\Controllers\Listings;

use App\Models\Agent;
use App\Models\Listing;
use App\Models\User;
use App\Models\Category;
use App\Models\Favourite;
use App\Models\Notification;
use App\Models\Review;

trait CompileListing
{

    // No of values to be displayed on each page due to pagination.
    private $NO_FOR_PAGINATION = 5;

    protected function compileListings($user)
    {
        $all = Listing::where('status', 'active')->paginate($this->NO_FOR_PAGINATION);
        // $all = Listing::where('status', 'active')->get();
        $listings = $this->formatListingsWithPagination($all, $user);
        return $listings;
    }

    protected function listingsPaginationMetaData($user)
    {
        $meta = Listing::where('status', 'active')->paginate($this->NO_FOR_PAGINATION);
        return $meta;
    }

    protected function compileListingWithQuery($request, $user)
    {
        // return 'man';

        $query = Listing::query();

        $query->when($request->query('state'), function ($q, $state) {
            return $q->where('state', $state);
        });
        $query->when($request->query('city'), function ($q, $lga) {
            return $q->where('city', $lga);
        });
        $query->when($request->query('type'), function ($q, $category) {
            return $q->where('type', $category);
        });
        $query->when($request->query('price'), function ($q, $rent) {
            switch ($rent) {
                case '1':
                    return $q->where('rent', "<", 200000);
                case '2':
                    return $q->where('rent', ">=", 200000)->where('rent', "<=", 400000);
                case '3':
                    return $q->where('rent', ">=", 400000)->where('rent', "<=", 800000);
                case '4':
                    return $q->where('rent', ">=", 800000)->where('rent', "<=", 2000000);
                case '5':
                    return $q->where('rent', ">=", 2000000);
                default:
                    return $q;
            }
        });

        $query->when($request->query('rooms'), function ($q, $rooms) {
            switch ($rooms) {
                case '10':
                    return $q->where('no_bedrooms', '>=', $rooms);
                default:
                    return $q->where('no_bedrooms', $rooms);
                    break;
            }
        });

        $query->when($request->query('sortby'), function ($q, $sortby) {
            switch ($sortby) {
                case 'views':
                    return $q->orderBy('views', 'desc');
                case 'minprice':
                    return $q->orderBy('rent');
                case 'maxprice':
                    return $q->orderBy('rent', 'desc');
                default:
                    return $q->latest();
            }
        });

        $query->where('status', '=', 'active');

        // $listings = $query->get();
        $listings = $query->paginate($this->NO_FOR_PAGINATION);

        return $this->formatListingsWithPagination($listings, $user);
    }

    /** Featured Listings */
    protected function compileFeaturedListings($user)
    {
        $user ? $user = User::find($user->unique_id) : $user = null;
        $related_listings = $this->fetchUserRelatedListings($user, 3);
        return $this->formatListingData($related_listings, $user);
    }

    private function fetchUserRelatedListings($user, $index)
    {
        $listings = [];

        $user && $user->state ? $state = $user->state : $state =  null;
        $user && $user->city ? $city = $user->city : $city = null;

        $state ? $by_state = Listing::where('state', $user->state)->where('status', 'active')->get() : $by_state = [];
        $city ? $by_city = Listing::where('city', $user->city)->where('status', 'active')->get() : $by_city = [];

        $related_listings = array_merge($by_state, $by_city);
        count($related_listings) < $index ? $listings = array_merge($related_listings, Listing::where('status', 'active')->get()->toArray()) : $listings = $related_listings;

        return $listings;
    }


    public function formatListingsWithPagination($listings, $user = null)
    {
        $array = [];

        if (count($listings) > 0) {
            for ($i = 0; $i < count($listings); $i++) {
                $listing = Listing::find($listings[$i]['unique_id']);
                $agent = Agent::find($listings[$i]['agent_id']);
                $is_Favourite = false;

                if ($user) {
                    $is_Favourite = Favourite::where('user_id', $user->unique_id)->where('listing_id', $listings[$i]['unique_id'])->first();
                }


                $listings[$i] = array_merge($listings[$i]->toArray(), [
                    'images' => json_decode($listings[$i]->images),
                    'created_at' => $this->parseTimestamp($listings[$i]->created_at)->date,
                    'isFavourite' => $is_Favourite,
                    'agent' => $agent,
                    'period' => $this->getDateInterval($listings[$i]->created_at)
                ]);
            }
        }

        return $listings;
    }


    public function formatListingData($listings, $user = null)
    {
        $array = [];

        if (count($listings) > 0) {
            foreach ($listings as $listing) {
                // return $listings;
                $listing = Listing::find($listing['unique_id']);
                $agent = Agent::find($listing['agent_id']);
                $is_Favourite = false;

                if ($user) {
                    $is_Favourite = Favourite::where('user_id', $user->unique_id)->where('listing_id', $listing['unique_id'])->first();
                }

                $array[] = array_merge($listing->toArray(), [
                    'images' => json_decode($listing->images),
                    'created_at' => $this->parseTimestamp($listing->created_at)->date,
                    'isFavourite' => $is_Favourite,
                    'agent' => $agent,
                    'period' => $this->getDateInterval($listing->created_at)
                ]);
            }
        }

        return $array;
    }

    private function compilePopularListings($user)
    {
        $array = [];
        $categories = Category::all();
        $i = 0;
        if (count($categories) > 0) {
            foreach ($categories as $key => $category) {
                $title = $category->category_title;

                $category_listings = Listing::where('type', $title)->where('status', 'active')->orderBy('views', 'desc')->limit(9)->get();
                $formatted_listings = $this->formatListingData($category_listings, $user);

                if (count($category_listings) > 0 && $i < 7) {
                    $slug = $this->createDelimitedString($title, ' ', '_');

                    $array[$i]['listings'] = $formatted_listings;
                    $array[$i]['category'] = [
                        'title' => $category->category_title,
                        'slug' => strtolower($slug)
                    ];
                    $i++;
                }
            }
        }

        return $array;
    }

    private function compileListingsByType($user)
    {
        $for_rent = Listing::where('tenure', '!=', 'sale')
            ->limit(10)
            ->latest()
            ->get();

        $rented_listings = $this->formatListingData($for_rent, $user);

        $for_sale = Listing::where('tenure', 'sale')->latest()->limit(10)->get();
        $selling_listings = $this->formatListingData($for_sale, $user);

        return [
            'rented' => $rented_listings,
            'on_sale' => $selling_listings
        ];
    }


    private $model;
    public function formatListingDetails($details, $model)
    {
        $this->model = app("App\\Models\\$model");
        $array = count($details) > 0
            ? $array = array_map(
                fn ($key, $value) => [$this->model->where('slug', $key)->first(), 'value' => $value],
                array_keys($details),
                array_values($details)
            ) : [];

        return $array;
    }

    public function clearListingData($listing, $agent)
    {
        $id = $listing->unique_id;

        $agent->no_of_listings = $agent->no_of_listings > 0 ? $agent->no_of_listings - 1 : 0;
        $agent->save();


        Review::where('listing_id', $id)->delete();
        Favourite::where('listing_id', $id)->delete();
        Notification::where('type_id', $id)->delete();

        $listing->delete();
    }
}
