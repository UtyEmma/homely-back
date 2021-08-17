<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Auth\Auth;
use App\Http\Requests\Auth\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function update(UpdateUserRequest $request){
        $user = auth()->user();
        try {
            
            $request->hasFile('avatar') ? $files = $this->handleFiles($request->file('avatar')) : $files = [];
            User::find($user->unique_id)->update(array_merge($request->validated(), ['avatar' => json_encode($files)]));

        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        $user = User::find($user->unique_id);
        $tenant = array_merge($user->toArray(), ['avatar' => json_decode($user->avatar)[0]]);

        return $this->success("User Profile Updated!!!", [ 'tenant' => $tenant ]);
    }

    public function getLoggedInUser(){
        return $this->success("Logged In User Loaded", $this->user);
    }

    public function show(User $user){
        return !$user ? $this->error(404, "User Not Found") : $this->success("", $user);
    }

    public function deleteUserAccount($user){
        if(!$user = User::find($user)){return $this->error(404, "User Not Found");}
        try {
            $user->delete();
        }catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }
        Auth::logout();
        return $this->success('Account Deleted');
    }

}
