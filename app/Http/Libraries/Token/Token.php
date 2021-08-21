<?php

namespace App\HTTP\Libraries\Token;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Token {

    protected function generateId(){
        $uuid = (string) Str::uuid();
        $trim = explode('-', $uuid);
        $id = $trim[4];
        return $id;
    }
        
    protected function createUniqueToken($table, $column){
        $id = $this->generateId();  
        DB::table($table)->where($column, '=', $id)->first() ? $status = false : $status = $id;    

        if (!$status) { return $this->createUniqueToken($table, $column); }
        return $status;                
    }
    
    protected function createRandomToken(){
        $random = rand(10000, 99999);
        return $random;
    }
}