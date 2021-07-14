<?php

namespace App\Http\Controllers;

use App\Http\Libraries\Auth\Auth;
use App\Http\Libraries\Files\FileHandler;
use App\Http\Libraries\ResponseStatus\ResponseStatus;
use App\HTTP\Libraries\Token\Token;
use App\Http\Libraries\VerifyEmail\VerifyEmail;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Token, VerifyEmail, ResponseStatus, 
        FileHandler, Auth;

    
    protected function deleteModel($model, $name){
        try {
            $model->delete();
            return redirect()->back()->with('message', "$name Deleted");
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }


    protected function suspendModel($model, $name){
        try{
            $model->status ? $model->status = false : $model->status = true;
            $model->save();
            return redirect()->back()->with('message', "$name Suspended");
        } catch (Exception $e) {
            return redirect()->back()->with('message', $e->getMessage());
        }
    }
}
