<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Models\Review;

class ReviewController extends Controller
{
    public function createReview(Request $request, $listing_id){
        try {
            $user = $this->tenant();
            $unique_id = $this->createUniqueToken('reviews', 'unique_id');
            Review::create(array_merge($request->all(), [
                'reviewer_id' => $user->unique_id,
                'listing_id' => $listing_id
            ]));
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success('Your Review has been Submitted');
    }
}
