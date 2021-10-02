<?php

namespace App\Http\Controllers\Details;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Category;
use Exception;
use Illuminate\Support\Arr;

class DetailController extends Controller
{
    public function fetchDetails(){
        try {
            $amenities = $this->formatDetails(Amenities::select('amenity_title')->get(), 'amenity_title');
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        return $this->success('Details Fetched', [ 'amenities' => $amenities ]);
    }

    private function formatDetails ($details, $title){
        $array = [];
        $array = array_map(function($item) use ($title) {
            return $item[$title];
        }, $details->toArray());
        $sorted_array = Arr::sort($array);
        return $sorted_array;
    }

    public function fetchCategories(){
        try {
            $categories = Category::all();
            $array = count($categories) > 0 ? $categories : [];
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Categories Retrived", $array);
    }
}
