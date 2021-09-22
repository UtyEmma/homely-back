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
        $user = auth()->user();
        $email_updated = false;

        try {
            $old_email = $user->email;

            $files = $request->hasFile('avatar') ? $this->handleFiles($request->file('avatar')) : $user->avatar;

            if ($request->email !== $user->email) { $email_updated = true; }

            User::find($user->unique_id)->update(array_merge(
                $request->validated(), [
                    'avatar' => $files ? json_decode($files)[0] : null
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

        return $this->success("User Profile Updated!!!", [ 'tenant' => $user, 'email_updated' => $email_updated ]);
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
