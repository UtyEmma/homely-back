<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Amenities;
use App\Models\Admin\Feature;
use Exception;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function createFeatures(){
        
    }
    
    public function createAmenities(){

    }

    public function getDetails () {
        try {
            $features = Feature::all();
            $amenities = Amenities::all();
            return $this->success('Details Loaded', [
                'features' => $features,
                'amenities' => $amenities
            ]);

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
    }
}
