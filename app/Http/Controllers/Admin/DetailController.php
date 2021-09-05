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
            return redirect()->back()->with('error', $e->getMessage());
        }
            
        return redirect()->back()->with('success', 'Feature Created');
    }
    
    public function createAmenities(CreateAmenityRequest $request){
        try {
            $unique_id = $this->createUniqueToken('amenities', 'unique_id');
            
            Amenities::create(array_merge($request->all(), [
                'unique_id' => $unique_id
            ]));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
            
        return redirect()->back()->with('success', 'Amenity Created');
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

    public function updateAmenity (Request $request, $id) {
        if (!$amenity = Amenities::find($id)) { return redirect()->back()->with('error', 'Amenity not Found'); }
        $amenity->amenity_title = $request->amenity_title;
        $amenity->save();
        return redirect()->back()->with('success', 'Amenity Updated');
    }

    public function deleteAmenity ($id) {
        if (!$amenity = Amenities::find($id)) { return redirect()->back()->with('error', 'Amenity not Found'); }
        $amenity->delete();
        return redirect()->back()->with('success', 'Amenity Deleted');
    }

    public function suspendAmenity ($id) {
        if (!$amenity = Amenities::find($id)) { return redirect()->back()->with('error', 'Amenity not Found'); }
        $amenity->status = !$amenity->status;
        $amenity->save();

        $message = $amenity->status ? 'Restored' : 'Suspended';
 
        return redirect()->back()->with('success', "Amenity $message");
    }
}
