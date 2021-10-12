<?php
namespace App\Http\Controllers\Admin\Utils;

use App\Models\Agent;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

trait CompileItems {

    public function sortTenants (Request $request){
        $user = User::query();

        $user->when($request->query('sort'), function($q, $item){
            switch ($item) {
                case 'email_verified':
                    return $q->where('isVerified', true);
                case 'email_not_verified':
                    return $q->where('isVerified', false);
                case 'suspended':
                    return $q->where('status', false);
                case 'active':
                    return $q->where('status', true);
                default:
                    break;
            }
        });

        return $user->paginate(15);
    }


    public function sortAgents (Request $request){
        $user = Agent::query();

        $user->when($request->query('sort'), function($q, $item){
            switch ($item) {
                case 'confirmed':
                    return $q->where('status', '!==' ,'pending');
                case 'not_confirmed':
                    return $q->where('status', 'pending');
                case 'email_verified':
                    return $q->where('isVerified', true);
                case 'email_not_verified':
                    return $q->where('isVerified', false);
                case 'verified_agents':
                    return  $q->where('verified', true);
                case 'unverified_agents':
                    return  $q->where('verified', false);
                case 'suspended':
                    return  $q->where('status', 'suspended');
                case 'active':
                    return  $q->where('status', 'active');
                default:
                    break;
            }
        });

        return $user->paginate(15);
    }

    public function sortListings (Request $request){
        $user = Listing::query();

        $user->when($request->query('sort'), function($q, $item){
            switch ($item) {
                case 'confirmed':
                    return $q->where('status', '!==' ,'pending');
                case 'not_confirmed':
                    return $q->where('status', 'pending');
                case 'rented':
                    return  $q->where('rented', true);
                case 'not_rented':
                    return  $q->where('rented', false);
                case 'suspended':
                    return  $q->where('status', 'suspended');
                case 'active':
                    return  $q->where('status', 'active');
                default:
                    break;
            }
        });

        return $user->paginate(15);
    }

}
