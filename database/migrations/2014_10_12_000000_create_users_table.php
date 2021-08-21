<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('isVerified');
            $table->string('state');
            $table->string('lga');
            $table->integer('wishlists');
            $table->boolean('status');
            $table->string('auth_driver')->nullable();
            $table->string('password')->nullable();
            $table->string('password_reset')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
