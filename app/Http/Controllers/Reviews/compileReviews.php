<?php

namespace App\Http\Controllers\Reviews;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Libraries\Functions\DateFunctions;

trait CompileReviews{
    use DateFunctions;

    protected function compileReviewsData($reviews){
        $array = [];
        $i = 0;
        $user = auth('tenant')->user();

        if (count($reviews) > 0) {
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
        $ratings = Reviews::select('rating')->where($type, $id)->get();
        $total_ratings = 0;
        foreach ($ratings as  $value) {
            $total_ratings = $total_ratings + $value;
        }
        return $total_ratings/ count($ratings);
    }
}
