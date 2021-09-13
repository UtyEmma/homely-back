<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Review;
use App\Models\Listing;
use App\Models\Agent;
use App\Http\Controllers\Reviews\CompileReviews;
use App\Http\Libraries\Notifications\NotificationHandler;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller{

    use CompileReviews, NotificationHandler;

    public function createReview(Request $request, $listing_id){
        $user = auth()->user();

        if (Review::where('listing_id', $listing_id)->where('reviewer_id', $user->unique_id)->first()) {
            return $this->error(405, "You have already reviewed this Listing");
        }

        try {
            $unique_id = $this->createUniqueToken('reviews', 'unique_id');
            $agent = Listing::find($listing_id)->agent;

            // $agent_id = Listing::select('agent_id')->where($listing_id)->first();
            // $agent = Agent::find($agent_id);

            Review::create(array_merge($request->all(), [
                'reviewer_id' => $user->unique_id,
                'listing_id' => $listing_id,
                'agent_id' => $agent->unique_id,
                'unique_id' => $unique_id
            ]));

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $agent->no_reviews = $agent->no_reviews + 1;
        $agent->rating = $this->calculateRatings($agent->unique_id, 'agent_id');
        $agent->save();

        $listing = Listing::find($listing_id);
        $listing->rating = $this->calculateRatings($listing_id, 'listing_id');

        $listings_reviews = Listing::find($listing_id)->reviews;
        $reviews = $this->compileReviewsData($listings_reviews);

        $data = [
            'type_id' => $unique_id,
            'publisher_id' => $user->unique_id,
            'receiver_id' => $agent->unique_id,
            'message' => 'You have received a new review'
        ];

        $this->makeNotification('review', $data);

        return $this->success('Your Review has been Submitted', $reviews);
    }



    public function fetchAgentReviews(){
        try{
            $agent = auth()->user();
            $agents_reviews = Agent::find($agent->unique_id)->reviews;
            $reviews = $this->compileReviewsData($agents_reviews);
        }catch(Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Agent's Reviews Fetched", [
            'reviews' => $reviews,
            'count' => count($reviews)
        ]);
    }


    public function fetchListingReviews($listing_id){
        try {
            $listings_reviews = Review::where('listing_id', $listing_id)->where('status', true)->get();

            $reviews = $this->compileReviewsData($listings_reviews);
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        return $this->success('Fetched Reviews', $reviews);
    }


    public function reportUser(Request $request, $review_id){
        try {
            $validated = Validator::make([
                'report' => 'required|string'
            ]);

            $review = Review::find($review_id);
            $review->update([
                'report' => $request->report,
                'reported' => true
            ]);
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }

    public function updateReview(Request $request){
        try {
            $user = auth()->user();
            $this->checkIfReviewBelongstoCurrentUser($request->unique_id);
            Review::where('unique_id', $request->unique_id)->update((array) $request->all());
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $review = Review::find($request->unique_id);
        return $this->success("Your Review has been updated", [
            'review' => $review
        ]);
    }


    public function deleteReview($review_id){
        try {
            $user = auth()->user();
            $this->checkIfReviewBelongstoCurrentUser($review_id);
            Review::find($review_id)->delete();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        $review = Review::find($review_id);
        return $this->success("Your Review has been Deleted");
    }


}
