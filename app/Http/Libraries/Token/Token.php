<?php

namespace App\HTTP\Libraries\Token;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

trait Token {

    /**
     * Generate a Short UUID Token
     *
     * @return void
     */
    protected function generateId(){
        $uuid = (string) Str::uuid();
        $trim = explode('-', $uuid);
        $id = $trim[4];
        return $id;
    }
        
    /**
     * Check if the Generated UUID Token is used
     *
     * @param  mixed $table
     * @return void
     */
    protected function createUniqueToken($table, $column){
        $id = $this->generateId();  
        DB::table($table)->where($column, '=', $id)->first() ? $status = false : $status = $id;    

        if (!$status) {
            return $this->make($table, $column);
        }
        return $status;                
    }
    
    protected function createRandomToken($table, $column){
        $random = rand(10000, 99999);
        return $random;
    }
}