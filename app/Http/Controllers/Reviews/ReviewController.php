<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Review;
use App\Models\Listing;
use App\Models\Agent;
use App\Http\Controllers\Reviews\CompileReview;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller{

    use CompileReview, NotificationHandler;

    public function createReview(Request $request, $listing_id){
        auth()->shouldUse($request->role);
        try {
            $user = auth()->user();

            if(!$user){
                throw new Exception("Invalid User Details", 401);
            }

            if (Review::where('listing_id', $listing_id)->where('reviewer_id', $user->unique_id)->first()) {
                throw new Exception("You have already reviewed this Listing", 400);
            }

            $unique_id = $this->createUniqueToken('reviews', 'unique_id');
            $agent = Listing::find($listing_id)->agent;

            Review::create(array_merge($request->all(), [
                'reviewer_id' => $user->unique_id,
                'listing_id' => $listing_id,
                'agent_id' => $agent->unique_id,
                'unique_id' => $unique_id
            ]));

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        $agent->no_reviews = $agent->no_reviews + 1;
        $agent->rating = $this->calculateRatings($agent->unique_id, 'agent_id');
        $agent->save();

        $listing = Listing::find($listing_id);
        $listing->reviews = $listing->reviews + 1;
        $listing->rating = $this->calculateRatings($listing_id, 'listing_id');
        $listing->save();

        $data = [
            'type_id' => $unique_id,
            'publisher_id' => $user->unique_id,
            'receiver_id' => $agent->unique_id,
            'message' => 'You have received a new review'
        ];

        $this->makeNotification('review', $data);

        $listings_reviews = Review::where('listing_id', $listing_id)->where('status', true)->get();
        $reviews = $this->compileReviewsData($listings_reviews, $request->role);

        return $this->success('Your review has been submitted', $reviews);
    }

    public function createAgentReview(Request $request, $agent_id){
        try {
            auth()->shouldUse($request->role);
            $user = auth()->user();

            if(!$user){
                throw new Exception("Invalid User Details", 401);
            }

            if (Review::where('agent_id', $agent_id)->where('listing_id', null)->where('reviewer_id', $user->unique_id)->first()) {
                throw new Exception("You have already reviewed this Agent", 400);
            }

            $unique_id = $this->createUniqueToken('reviews', 'unique_id');
            $agent = Agent::find($agent_id);

            Review::create(array_merge($request->all(), [
                'reviewer_id' => $user->unique_id,
                'agent_id' => $agent->unique_id,
                'unique_id' => $unique_id
            ]));

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        $agent->no_reviews = $agent->no_reviews + 1;
        $agent->rating = $this->calculateRatings($agent->unique_id, 'agent_id');
        $agent->save();

        $data = [
            'type_id' => $unique_id,
            'publisher_id' => $user->unique_id,
            'receiver_id' => $agent->unique_id,
            'message' => 'You have a new review'
        ];

        $this->makeNotification('review', $data);

        $agent_reviews = Review::where('agent_id', $agent_id)->where('listing_id', null)->where('status', true);
        $reviews = $this->compileReviewsData($agent_reviews, $request->role);
        return $this->success("Fetched Reviews", $reviews);
    }


    public function fetchAgentReviews(){
        try{
            $agent = auth()->user();

            if(!$agent){
                throw new Exception("Invalid User Details", 401);
            }

            $agents_reviews = Agent::find($agent->unique_id)->reviews;
            $reviews = $this->compileReviewsData($agents_reviews);
        }catch(Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Agent's Reviews Fetched", [
            'reviews' => $reviews,
            'count' => count($reviews)
        ]);
    }


    public function fetchListingReviews(Request $request, $listing_id, $message = ""){
        auth()->shouldUse($request->role);
        try {
            $listings_reviews = Review::where('listing_id', $listing_id)->where('status', true)->get();
            $reviews = $this->compileReviewsData($listings_reviews);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        return $this->success($message ?: 'Fetched Reviews', $reviews);
    }


    public function reportUser(Request $request, $review_id){
        try {
            Validator::make([
                'report' => 'required|string'
            ]);

            $review = Review::find($review_id);
            $review->update([
                'report' => $request->report,
                'reported' => true
            ]);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
    }

    public function updateReview(Request $request){
        auth()->shouldUse($request->role);
        try {
            $user = auth()->user();
            if(!$user){
                throw new Exception("Invalid User Details", 401);
            }
            $this->checkIfReviewBelongstoCurrentUser($request->unique_id, $user);
            $review = Review::find($request->unique_id);
            Review::where('unique_id', $request->unique_id)->update($request->except('role'));

            if ($review->listing_id) {
                $listing = Listing::find($review->listing_id);
                $listing->rating = $this->calculateRatings($review->listing_id, 'listing_id');
                $listing->save();
            }

            $agent = Agent::find($review->agent_id);
            $agent->rating = $this->calculateRatings($agent->unique_id, 'agent_id');
            $agent->save();

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        $review = Review::find($request->unique_id);
        return $this->fetchListingReviews($request, $review->listing_id, "Your Review has been updated");


    }


    public function deleteReview(Request $request, $review_id){
        try {
            auth()->shouldUse($request->role);
            $user = auth()->user();

            if(!$user){
                throw new Exception("Invalid User Details", 401);
            }

            $this->checkIfReviewBelongstoCurrentUser($review_id, $user);

            $review = Review::find($review_id);

            if ($listing_id = $review->listing_id) {
                $listing = Listing::find($listing_id);
                $listing->reviews = $listing->reviews - 1;
                $listing->rating = $this->calculateRatings($listing_id, 'listing_id');
                $listing->save();
            }


            $agent = Agent::find($review->agent_id);
            $agent->no_reviews = $agent->no_reviews - 1;
            $agent->rating = $this->calculateRatings($agent->unique_id, 'agent_id');
            $agent->save();

            Notification::where('type_id', $review_id)->delete();

            $review->delete();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->fetchListingReviews($request, $listing_id, "Your Review has been deleted");
    }


}
