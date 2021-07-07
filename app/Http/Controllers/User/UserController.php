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
        try {
            $request->hasFile('avatar') ? $files = $this->upload($request->file('avatar'), 'user')
                                        : $files = [];

            User::find($this->user->id)->update(
                                            array_merge($request->validated(), ['files' => $files])
                                        ); 
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("User Profile Updated!!!");
    }


    public function getLoggedInUser(){
        return $this->success("Logged In User Loaded", $this->user);
    }

    public function show(User $user){
        return !$user ? $this->error(404, "User Not Found") : $this->success("", $user);
    }

    public function deleteUserAccount(User $user){
        try {
            $user->delete();
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        Auth::logout();
        return $this->success('Account Deleted');
    }
}
