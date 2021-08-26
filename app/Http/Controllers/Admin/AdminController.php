<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function singleAdmin($id){
        if ($admin = Admin::find($id)) {
            return view('admins.admin-details', ['admin' => $admin]);
        }else{
            return redirect()->back()->with('error', 'Admin Does not Exist!!!');
        }
    }

    public function deleteAdmin($id){
        if ($admin = Admin::find($id)) {
            try {
                $admin->delete();
                return redirect()->back()->with('success', "Admin Deleted");
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }else{
            return redirect()->back()->with('error', "Admin does not Exist");
        }
    }

    
    public function suspendAdmin($id){
        if ($admin = Admin::find($id)) {
            try {
                $admin->status = !$admin->status;
                $admin->save();

                $message = $admin->status ? 'Restored' : 'Suspended'; 
                
                return redirect()->back()->with('success', "Admin ".$message);
            } catch (Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        }else{
            return redirect()->back()->with('error', "Admin does not Exist");
        }
    }

    public function update(UpdateAdminRequest $request){
        try {
            $validated = $request->validated();
            $admin_id = auth()->user()->unique_id;

            Admin::find($admin_id)->update($validated);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return view('profile', ['admin' => auth()->user()]);
    }
}
