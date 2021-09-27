<?php

namespace App\Policies;

use App\Models\Admin;
use App\Models\Agent;
use App\Models\Listing;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ListingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function viewAny(Admin $admin)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Listing  $listing
     * @return mixed
     */
    public function view(Admin $admin, Listing $listing)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\Admin  $admin
     * @return mixed
     */
    public function create(Admin $admin){
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\Agent  $agent
     * @param  \App\Models\Listing  $listing
     * @return mixed
     */
    public function update(Agent $agent, Listing $listing)
    {
        return $agent->unique_id === $listing->agent_id
                    ? Response::allow()
                        : Response::deny("You are not authorized to update this listing");
    }

    public function makeChanges(Listing $listing){
        return $listing->status !== 'pending';
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Listing  $listing
     * @return mixed
     */
    public function delete(Admin $admin, Listing $listing)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Listing  $listing
     * @return mixed
     */
    public function restore(Admin $admin, Listing $listing)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin  $admin
     * @param  \App\Models\Listing  $listing
     * @return mixed
     */
    public function forceDelete(Admin $admin, Listing $listing)
    {
        //
    }
}
