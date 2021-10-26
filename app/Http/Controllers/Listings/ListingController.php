<?php

namespace App\Http\Controllers\Listings;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Http\Requests\Listings\CreateListingRequest;
use App\Models\Agent;
use App\Models\Listing;
use App\Models\Notification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class ListingController extends Controller
{

    use CompileListing, NotificationHandler;

    public function createListing(CreateListingRequest $request)
    {
        try {
            $agent = auth()->user();

            $files = $request->hasFile('images') ? $this->handleFiles($request->file('images')) : [];
            $inital_fees = $request->rent + $request->extra_fees;

            $listing_id = $this->createUniqueToken('listings', 'unique_id');
            $slug = Str::slug($request->title, '-');

            Listing::create(array_merge($request->all(), [
                'unique_id' => $listing_id,
                'agent_id' => $agent->unique_id,
                'amenities' => json_encode($request->amenities),
                'images' => $files,
                'slug' => strtolower($slug),
                'initial_fees' => $inital_fees
            ]));

            $listing = Listing::find($listing_id);

            $data = [
                'type_id' => $listing_id,
                'message' => $listing->title . ' has been created and is being reviewed!',
                'publisher_id' => $agent->unique_id,
                'receiver_id' => $agent->unique_id,
            ];

            $this->makeNotification('listing', $data);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($request->title . " has been added to your Listings", [
            'listing' => array_merge($listing->toArray(), ['images' => json_decode($listing->images)]),
            'agent' => $agent
        ]);
    }


    public function getAgentsListings()
    {
        try {
            $agent = auth()->user();
            $array = [];
            $listings = Agent::find($agent->unique_id)->listings;
            $i = 0;

            if (count($listings) > 0) {
                foreach ($listings as $listing) {
                    $array[$i] = array_merge($listing->toArray(), [
                        'image' => json_decode($listing->images),
                        'amenities' => json_decode($listing->amenities),
                        'created_at' => $this->parseTimestamp($listing->created_at)->date
                    ]);
                    $i++;
                }
            }
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Listings Loaded", [
            'listings' => $array,
            'count' => count($array)
        ]);
    }

    public function agentRemoveListing($listing_id)
    {
        try {
            $agent = auth()->user();
            $i = 0;
            $listing = Listing::find($listing_id);
            $listing->status == 'inactive' ? $listing->status = 'active' : $listing->status = 'inactive';
            $listing->save();

            $listings = Agent::find($agent->unique_id)->listings;

            $array = $this->formatListingData($listings, $agent);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success('Property Removed Successfully', [
            'listings' => $array,
            'agent' => $agent,
            'count' => count($listings)
        ]);
    }

    public function fetchListings(Request $request)
    {
        try {
            auth()->shouldUse('tenant');
            $user = auth()->user();
            $listings  = count($request->query()) < 1 ?  $this->compileListings($user) : $this->compileListingWithQuery($request, $user);


            $featured_listings = $this->compileFeaturedListings($user);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage() . " Line:" . $e->getLine());
        }
        return $this->success("Listings Loaded", [
            'listings' => $listings,
            'featured' => $featured_listings,
        ]);
    }

    public function fetchPopularListings()
    {
        try {
            $user = auth()->user();
            $popular_listings = $this->compilePopularListings($user);
            $compiledByDuration = $this->compileListingsByType($user);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Popular Listings Fetched", [
            'popular' => $popular_listings,
            'rented' => $compiledByDuration['rented'],
            'on_sale' => $compiledByDuration['on_sale']
        ]);
    }

    public function deleteListing($listing_id)
    {
        try {
            if (!$listing = Listing::find($listing_id)) {
                throw new Exception("Listing Not Found", 404);
            }

            $agent = Agent::find($listing->agent_id);
            $agent->no_of_listings = $agent->no_of_listings - 1;

            $agent->save();
            $this->clearListingData($listing, $agent);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Listing Deleted", ['agent' => $agent]);
    }

    public function getSingleListing($username, $slug, $message = "")
    {
        try {
            if (!$agent = Agent::where('username', $username)->first()) {
                throw new Exception("This Agent Does Not Exist", 404);
            }
            if (!$listing = Listing::where('slug', $slug)->where('agent_id', $agent->unique_id)->first()) {
                throw new Exception("The Requested Listing Does Not Exist", 404);
            }
            $features = $this->formatListingDetails((array) json_decode($listing->features), "Feature");

            $single_listing = array_merge($listing->toArray(), [
                'features' => $features,
                'details' => json_decode($listing->details),
                'images' => json_decode($listing->images),
                'period' => $this->getDateInterval($listing->created_at)
            ]);

            $agent = Agent::find($listing->agent_id);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($message, [
            'listing' => $single_listing,
            'agent' => $agent->toArray()
        ]);
    }


    public function updateListing(Request $request, $listing_id)
    {
        try {
            $agent = auth()->user();

            Validator::make($request->all(), [
                'images.*' => ['required', 'image', 'mimes:jpeg,png,gif,webp', 'max:2048'],
                'title' => ['required', Rule::unique('listings', 'title')->ignore($listing_id, 'unique_id')],
                'tenure' => ['required', 'string'],
                'rent' => ['required', 'numeric'],
                'extra_fees' => ['nullable', 'numeric'],
                'video_links' => ['nullable', 'string', 'url'],
                'state' => ['required', 'string'],
                'city' => ['required', 'string'],
                'address' => ['required', 'string'],
                'landmark' => ['nullable', 'string'],
                'longitude' => ['required'],
                'latitude' => ['required'],
                'no_bedrooms' => ['required', 'numeric'],
                'no_bathrooms' => ['required', 'numeric'],
                'extra_info' => ['nullable', 'string'],
                'amenities.*' => ['nullable']
            ]);

            $listing = Listing::find($listing_id);
            $agent = Agent::find($listing->agent_id);

            if ($request->hasFile('images')) {
                $images = json_decode($listing->images);
                foreach ($images as $image) {
                    $this->deleteFile($image);
                }
            } else {
                throw new Exception("Property Images are Required", 400);
            }

            $files = $request->hasFile('images') ? $this->handleFiles($request->file('images')) : [];
            $inital_fees = $request->rent + $request->extra_fees;

            $slug = $this->createDelimitedString($request->title, ' ', '-');

            Listing::find($listing_id)->update(array_merge($request->all(), [
                'agent_id' => $agent->unique_id,
                'amenities' => json_encode($request->amenities),
                'images' => $files,
                'slug' => strtolower($slug),
                'initial_fees' => $inital_fees
            ]));
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage() . " :--- " . $e->getLine());
        }


        return $this->getSingleListing($agent->username, $slug, "Your Property has been updated successfully");
    }

    public function setListingAsRented($listing_id)
    {
        try {
            $user = auth()->user();
            if (!$listing = Listing::find($listing_id)) {
                throw new Exception("Listing Not Found", 404);
            }

            if ($listing->rented && $listing->status = 'rented') {
                $listing->rented = false;
                $listing->status = 'active';
                $listing->save();
            } else {
                $listing->rented = true;
                $listing->status = 'rented';
                $listing->save();
            }

            $data = [
                'type_id' => $listing_id,
                'message' => $listing->rented ? $listing->title . ' has been set as Available!' : $listing->title . ' has been set as Rented!',
                'publisher_id' => $user->unique_id,
                'receiver_id' => $listing->agent_id
            ];

            $this->makeNotification('listing_rented', $data);

            $message = $listing->rented ? "Property Set as Rented" : "Property Set as Available";
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->getSingleListing($user->username, $listing->slug, $message);
    }

    public function suspendListing($listing_id)
    {
        try {
            $user = auth()->user();
            if (!$listing = Listing::find($listing_id)) {
                throw new Exception("Listing Not Found", 404);
            }
            $listing->status = $listing->status === 'suspended' ? 'active' : 'suspended';
            $listing->save();

            $data = [
                'type_id' => $listing_id,
                'message' => $listing->status === 'suspended' ? 'Your Property has been suspended!' : 'Your Property has been Restored!',
                'publisher_id' => $user->unique_id,
                'receiver_id' => $listing->agent_id
            ];

            $this->makeNotification('listing_suspended', $data);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->getSingleListing($user->username, $listing->slug, "Listing " . $listing->status);
    }

    public function adminSuspendListing($listing_id)
    {
        try {
            if (!$listing = Listing::find($listing_id)) {
                throw new Exception("Listing Not Found", 404);
            }
            $listing->status = $listing->status === 'suspended' ? 'active' : 'suspended';
            $listing->save();

            $data = [
                'type_id' => $listing_id,
                'message' => $listing->status === 'suspended' ? 'Your Property has been suspended! Please contact support' : 'Your Property has been Restored!',
                'publisher_id' => $listing->agent_id,
                'receiver_id' => $listing->agent_id
            ];

            $this->makeNotification('listing', $data);

            $agent = Agent::find($listing->agent_id);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->getSingleListing($agent->username, $listing->slug, "Listing $listing->status");
    }
}
