<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function single($id){

    }


    public function deleteTenant($id){
        if ($tenant = User::find($id)) {
            try {
                $tenant->delete();
                return redirect('tenants')->with('message', "Tenant Deleted");
            } catch (Exception $e) {
                return redirect('tenants')->with('message', $e->getMessage());
            }
        }else{
            return redirect('tenants')->with('message', "Tenant does not Exist");
        }
    }

    public function suspendTenant($id){
        if ($tenant = User::find($id)) {
            try {
                $tenant->status = false;
                $tenant->save();
                
                return redirect('tenants')->with('message', "Tenant Suspended");
            } catch (Exception $e) {
                return redirect('tenants')->with('message', $e->getMessage());
            }
        }else{
            return redirect('tenents')->with('message', "Tenant does not Exist");
        }
    }
}
