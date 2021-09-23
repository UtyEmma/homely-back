<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\AdminLoginRequest;
use App\Http\Requests\Admin\Auth\AdminSignupRequest;
use App\Models\Admin;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login (AdminLoginRequest $request){
        if (!Auth::attempt($request->validated())) {
               return redirect()->back()->with('error', "Incorrect Email or Password");
        }

        $id = Auth::id();
        $admin = Admin::find($id);
        $admin->isLoggedIn = true;
        $admin->save();

        return redirect('/')->with('success', 'Login Successful');
    }

    public function signup(AdminSignupRequest $request){

        try {
            $unique_id = $this->createUniqueToken('admins', 'unique_id');
            $h_password = Hash::make($request->password);

            Admin::create(array_merge($request->validated(), [
                'unique_id' => $unique_id, 'password' => $h_password
            ]));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect('login')->with('success', 'Admin Registration Successful');
    }

    public function logout(Request $request){
        $id = Auth::id();

        $admin = Admin::find($id);
        $admin->isLoggedIn = false;
        $admin->save();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Logout Successful');
    }


}
