<?php

namespace App\Http\Controllers\Reviews;

use App\Models\User;
use App\Http\Libraries\Functions\DateFunctions;
use App\Models\Agent;
use App\Models\Review;
use Exception;

trait CompileReview{
    use DateFunctions;

    protected function compileReviewsData($reviews){
        $array = [];
        $i = 0;
        $user = auth('tenant')->user();

        if ($reviews && count($reviews) > 0) {
            foreach ($reviews as $key => $review) {
                $owned_by_user = false;
                if($publisher = User::find($review->reviewer_id)){
                    if ($user && $review->reviewer_id === $user->unique_id) {
                        $owned_by_user = true;
                    }

                    $array[$i]['review'] = array_merge($review->toArray(), [
                        'owned_by_user' => $owned_by_user,
                        'created_at' => $this->parseTimestamp($review->created_at)
                    ]);
                    $array[$i]['publisher'] =  $publisher;
                }

                $i++;
            }
        }

        return $array;
    }

    protected function calculateRatings($id, $type){
        $ratings = Review::select('rating')->where($type, $id)->get();
        $total_ratings = 0;
        foreach ($ratings as  $value) {
            $total_ratings = $total_ratings + $value->rating;
        }
        return $total_ratings/ count($ratings);
    }

    protected function matchReviewToListing($reviews){
        $array = [];
        if (count($reviews) > 0) {
            foreach ($reviews as $key => $review) {
                $listing = Review::find($review->unique_id)->listing;
                $publisher = Review::find($review->unique_id)->publisher;
                $agent = Agent::find($listing->agent_id);
                if ($listing) {
                    $array[] = array_merge($review->toArray(), [
                        'listing_title' => $listing->title,
                        'listing_slug' => $listing->slug,
                        'publisher_name' => $publisher->firstname." ".$publisher->lastname,
                        'agent_username' => $agent->username
                    ]);
                }
            }
        }
        return $array;
    }

    protected function checkIfReviewBelongstoCurrentUser ($review_id) {
        if (!Review::find($review_id)) { throw new Exception("Sorry! The Review does not exist!", 404); }
        if (!$review = Review::find($review_id)->publisher) {
            throw new Exception("The review does not belong to the current user", 400);
        }
    }
}
