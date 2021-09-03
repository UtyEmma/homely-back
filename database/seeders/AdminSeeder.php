<?php

namespace Database\Seeders;

use App\Http\Libraries\Token\Token;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder{
    use Token;

    public function __construct()
    {
        return $this->run();
    }

    public function run(){
        $unique_id = $this->createUniqueToken('admins', 'unique_id');
        if (!Admin::where('email', 'admin@richpinger.com')->first()) {
            DB::table('admins')->insert([
                'unique_id' => $unique_id,
                'firstname' => 'Default',
                'lastname' => 'Administrator',
                'email' => 'admin@bayof.co',
                'role' => 'Super Administrator',
                'status' => true,
                'isLoggedIn' => false,
                'password' => Hash::make('1234'),
                'created_at' => Date::now(),
                'updated_at' => Date::now()
            ]);   
        }
        return true;
    }
}
