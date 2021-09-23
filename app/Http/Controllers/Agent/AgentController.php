<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Http\Requests\Agent\AgentUpdateRequest;
use App\Models\Agent;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Agent\CompileAgents;
use App\Http\Controllers\Listings\CompileListing;
use App\Http\Controllers\WishList\CompileWishlist;
use App\Http\Libraries\Notifications\NotificationHandler;
use App\Models\Listing;

class AgentController extends Controller
{
    use CompileAgents, CompileListing, CompileWishlist, NotificationHandler;

    private function isAgent($id) {
        if(!$agent = Agent::find($id)){throw new Exception("The Requested Agent does not Exist", 404);}
        return $agent;
    }

    public function update(AgentUpdateRequest $request){
        try {
            $agent = $this->agent();

            $files = $request->hasFile('avatar') ? $this->handleFiles($request->file('avatar')) : $agent->avatar;

            Agent::find($agent->unique_id)->update(array_merge($request->validated(), [
                                        'twitter' => $request->twitter,
                                        'facebook' => $request->facebook,
                                        'instagram' => $request->instagram,
                                        'avatar' => $files ? $files : null ])
                                    );
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $updated_agent = Agent::find($agent->unique_id);

        return $this->success("Agent Profile Updated!!!", [
            'agent' => $updated_agent
        ]);
    }

    private $rented = [];
    private $active = [];

    public function single($username, $message=""){
        try {
            if (!$agent = Agent::where('username', $username)->first()) { throw new Exception("User Not Found", 404); }

            $listings = Agent::find($agent->unique_id)->listings;
            $reviews = Agent::find($agent->unique_id)->reviews;

            auth()->shouldUse('tenant');
            $user = auth()->user();

            $formatted_listings = $this->formatListingData($listings, $user);
            $listings = collect($formatted_listings);


            $listings->filter(function($listing, $key){
                if ($listing['status'] === 'rented') {
                    array_push($this->rented, $listing);
                }
            });

            $listings->filter(function($listing, $key){
                if ($listing['status'] === 'active') {
                    array_push($this->active, $listing);
                }
            });

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success($message, [
            'agent' => $agent,
            'listing' => [
                'rented' => $this->rented,
                'active' => $this->active
            ],
            'reviews' => $reviews
        ]);
    }

    public function show(){
        try {
            $agents = $this->compileAgents();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("All Agents", [
            'agents' => $agents
        ]);
    }

    public function adminSuspendAgent($agent_id){
        try {
            if(!$agent = Agent::find($agent_id)){ throw new Exception("Listing Not Found", 404); }

            $user = Agent::find($agent->agent_id);
            $agent->status = $agent->status === 'suspended' ? 'active' : 'suspended';
            $agent->save();

            Listing::where('agent_id', $agent_id)->update('status', $agent->status === 'suspended' ? 'active' : 'suspended');

            $admin = auth()->user();

            $data = [
                'type_id' => $agent_id,
                'message' => $agent->status === 'suspended' ? 'Your Account has been suspeneded! Please contact our Support Center!' : 'Your account has been restored',
                'publisher_id' => $admin->unique_id,
                'receiver_id' => $agent_id
            ];

            $this->makeNotification('agent_suspended', $data);

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->single($agent->username, "Agent $agent->status");
    }

    public function adminVerifyAgent($agent_id){
        try {
            if(!$agent = Agent::find($agent_id)){ throw new Exception("Listing Not Found", 404); }
            $agent->verified = !$agent->verified;
            $agent->save();

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->single($agent->username, "Agent Verified");
    }

    public function deleteUserAccount(){
        try {
            $agent = auth()->user();
            $agent = Agent::find($agent->unique_id);
            Auth::logout();
            $agent->delete();
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        return $this->success('Account Deleted');
    }

    public function fetchAgentWishlists(){
        try {
            $agent = auth()->user();
            $wishlists = $this->compileAgentWishlist($agent->unique_id);
        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("Wishlists Fetched", $wishlists);
    }

    public function setStatusToUnavailable(){
        try {
            $user = auth()->user();
            $agent = Agent::find($user->agent_id);
            $agent->status = $agent->status === 'active' ? 'unavailable' : 'active';
            $agent->save();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->single($agent->username, "Agent Status Set To Unavailable");
    }


}
