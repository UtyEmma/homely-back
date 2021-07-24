<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenities;
use App\Models\Feature;
use App\Http\Requests\Admin\Properties\CreateAmenityRequest;
use App\Http\Requests\Admin\Properties\CreateFeatureRequest;
use Exception;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function createFeatures(CreateFeatureRequest $request){
        try {
            $unique_id = $this->createUniqueToken('features', 'unique_id');
            Feature::create(array_merge($request->all(), [
                'unique_id' => $unique_id
            ]));
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
            
        return redirect()->back()->with(['message', 'Feature Created']);
    }
    
    public function createAmenities(CreateAmenityRequest $request){
        try {
            $unique_id = $this->createUniqueToken('amenities', 'unique_id');
            Amenities::create(array_merge($request->all(), [
                'unique_id' => $unique_id
            ]));
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
            
        return redirect()->back()->with(['message', 'Amenity Created']);
    }

    public function getDetails (){
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
