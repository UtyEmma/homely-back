<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Passwords\UpdatePasswordRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller{

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
            $admin = auth()->user();
            $admin_id = $admin->unique_id;

            $request->hasFile('avatar') && $this->deleteFile($admin->avatar);
            $files = $request->hasFile('avatar') ? json_decode($this->handleFiles($request->file('avatar')))[0] : $admin->avatar;

            Admin::find($admin_id)->update(array_merge($validated, ['avatar' => $files]));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', "Profile Updated");
    }

    public function updatePassword(UpdatePasswordRequest $request){
        try {
            $auth = auth()->user();
            $admin = Admin::find($auth->unique_id);

            if(!Hash::check($request->old_password, $admin->password)){
                throw new Exception("Invalid Password Provided", 400);
            }

            $admin->password = Hash::make($request->password);
            $admin->save();

        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', "Password Updated");
    }
}
