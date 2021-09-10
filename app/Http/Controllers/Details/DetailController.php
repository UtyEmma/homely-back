<?php

namespace App\Http\Controllers\Details;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\Amenities;
use App\Models\Category;
use Exception;
use Illuminate\Support\Arr;

class DetailController extends Controller
{
    public function fetchDetails(){
        try {
            // $features = $this->formatDetails(Feature::select('feature_title')->get(), 'feature_title');
            $amenities = $this->formatDetails(Amenities::select('amenity_title')->get(), 'amenity_title');
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }


        return $this->success('Details Fetched', [
            // 'features' => json_decode(json_encode($features)),
            'amenities' => $amenities
        ]);
    }

    private function formatDetails ($detail, $title){
        $array = [];
        foreach ($detail as $key => $value) {
            $array[] = $value[$title];
        }
        $sorted_array = Arr::sort($array);
        return $sorted_array;
    }

    public function fetchCategories(){
        try {
            $categories = Category::all();
            $array = [];

            if (count($categories) > 0) { $array = $categories; }

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Categories Retrived", $array);
    }
}
