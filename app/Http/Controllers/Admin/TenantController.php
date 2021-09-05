<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;

class TenantController extends Controller{

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
            $tenant = $this->getTenantData($id);
            $tenant->delete();
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
