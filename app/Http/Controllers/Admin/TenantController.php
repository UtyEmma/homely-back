<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\CompileTenant;
use App\Models\Favourite;
use App\Models\Notification;
use App\Models\Review;
use App\Models\User;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;

class TenantController extends Controller{
    use CompileTenant;

    private function getTenantData($id) {
        if (!$user = User::find($id)) {
            throw new Exception("Tenant does not exist", 404);
        }else{
            return $user;
        }
    }

    public function single($id){
        try {
            $tenant = $this->getTenantData($id);
            $wishlists = Wishlist::where('user_id', $tenant->unique_id)->get();
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return view('tenants.single-tenant', [
            'tenant' => $tenant,
            'wishlists' => $wishlists,
            'page' => 'tenants',
        ]);
    }

    public function deleteTenant($id){
        try {
            if (!$tenant = User::find($id)) { throw new Exception("This tenant does not exist", 400); }
            $this->clearTenantData($tenant);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', "Tenant Deleted Successfully");
    }

    public function suspendTenant($id){
        try {
            $tenant = $this->getTenantData($id);
            $tenant->status = !$tenant->status;
            $tenant->save();

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        $message = $tenant->status ? "Unsuspended" : "Suspended";
        return redirect()->back()->with('success', "Tenant $message");
    }
}
