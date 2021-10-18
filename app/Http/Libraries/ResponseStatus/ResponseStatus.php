<?php

namespace App\Http\Libraries\ResponseStatus;

trait ResponseStatus {

    protected function success(string $message="", $data=[]){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    protected function error( $code, string $message="", $data=[]){
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function view(string $view, int $code = null, array $data = []){
        return response()->view($view, $data, $code);
    }

    protected function redirectBack(string $key = "", string $value = ""){
        if ($key) {
            return redirect()->back()->with($key, $value);
        }

        return redirect()->back();
    }



}
