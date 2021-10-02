<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Libraries\Auth\Auth;
use App\Http\Requests\Auth\User\UpdateUserRequest;
use App\Models\Notification;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller{

    public function update(UpdateUserRequest $request){
        try {
            $user = auth()->user();
            $email_updated = false;

            $request->hasFile('avatar') && $this->deleteFile($user->avatar);

            $files = $request->hasFile('avatar') ? json_decode($this->handleFiles($request->file('avatar')))[0] : $user->avatar;

            if ($request->email !== $user->email) { $email_updated = true; }

            User::find($user->unique_id)->update(array_merge(
                $request->validated(), [
                    'avatar' => $files
                ]
            ));

            $user = User::find($user->unique_id);

            if ($email_updated) {
                $user->isVerified = false;
                $user->save();
                $this->verify($user, 'tenant', false);
            }

        } catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }

        return $this->success("User Profile Updated!!!", [
            'user' => $user,
            'email_updated' => $email_updated
        ]);
    }

    public function show($user){
        return !$user = User::find($user) ? $this->error(404, "User Not Found") : $this->success("", $user);
    }

    public function deleteUserAccount($user){
        try {
            if(!$user = User::find($user)){ throw new Exception ("User Not Found", 400); }
            Notification::where('receiver_id', $user)->delete();
            $user->delete();
        }catch (Exception $e) {
            return $this->error($e->getCode(), $e->getMessage());
        }
        Auth::logout();
        return $this->success('Account Deleted');
    }

}
