<?php

namespace App\Http\Libraries\ResponseStatus;

trait ResponseStatus {

    protected function success($message="", $data=[]){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], 200);
    }

    protected function error($code, $message="", $data=''){
        return response()->json([
            'status' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function viewError(string $view, int $code, array $data = []){
        return response()->view($view, $data, $code);
    }

    protected function viewSuccess(string $view, array $data = []){
        return response()->view($view, $data, 200);
    }



}