<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller{

    function verifyAdmin ($id) {
        try {
            $admin = Admin::find($id) ?: throw new Exception("Admin Verification Aborted! Invalid Details Given!", 404 );
            $admin->isLoggedIn ?: throw new Exception("Please login to your Admin Dashboard to activate Admin Mode", 500);
            
        } catch (Exception $e) {
            return $this->error(500, $e->getMessage());
        }

        return $this->success("Admin Mode Activated", [
            'admin'  => base64_encode(json_encode($admin))
        ]);
    }
}
