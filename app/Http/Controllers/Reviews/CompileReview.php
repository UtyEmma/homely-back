<?php

namespace App\Http\Controllers\Reviews;

use App\Models\User;
use App\Http\Libraries\Functions\DateFunctions;
use App\Models\Agent;
use App\Models\Review;
use Exception;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Request;

trait CompileReview{
    use DateFunctions;

    function role () {
        $request = request()->all();
        return $request['role'];
    }

    protected function compileReviewsData($reviews){
        $array = [];
        $user = auth()->user();

        if ($reviews && count($reviews) > 0) {

            $array = $reviews->map(function($review) use ($user) {
                $owned_by_user = false;

                if($publisher = $this->reviewPublisher($review->reviewer_id)){

                    if ($user) : $owned_by_user = $review->reviewer_id === $user->unique_id; endif;

                    $review['review'] = array_merge($review->toArray(), [
                        'owned_by_user' => $owned_by_user,
                        'created_at' => $this->parseTimestamp($review->created_at)
                    ]);

                    $review['publisher'] =  $publisher;
                }

                return $review;
            });
        }

        return $array;
    }

    private function reviewPublisher ($reviewer_id) {
        $reviewer = User::find($reviewer_id) ?: Agent::find($reviewer_id);
        return $reviewer;
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

                $array[] = array_merge($review->toArray(), [
                    'listing_title' => $listing && $listing->title,
                    'listing_slug' => $listing && $listing->slug,
                    'publisher_name' => $publisher->firstname." ".$publisher->lastname,
                    'agent_username' => $agent->username
                ]);
            }
        }
        return $array;
    }

    protected function checkIfReviewBelongstoCurrentUser ($review_id, $user) {
        if (!$review = Review::find($review_id)) { throw new Exception("Sorry! The Review does not exist!", 400); }
        if ($review->reviewer_id !== $user->unique_id) {
            throw new Exception("The review does not belong to the current user", 400);
        }
    }
}
