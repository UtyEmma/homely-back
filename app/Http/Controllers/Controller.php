<?php

namespace App\Http\Controllers;

use App\Http\Libraries\Auth\Auth;
use App\Http\Libraries\Files\FileHandler;
use App\Http\Libraries\ResponseStatus\ResponseStatus;
use App\Http\Libraries\Token\Token;
use App\Http\Libraries\Functions\StringFunctions;
use App\Http\Libraries\Functions\DateFunctions;
use App\Http\Libraries\VerifyEmail\VerifyEmail;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Token, VerifyEmail, ResponseStatus, 
        FileHandler, Auth, StringFunctions, DateFunctions;


    
}
