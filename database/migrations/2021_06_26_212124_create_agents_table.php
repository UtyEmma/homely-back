<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('email')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('password')->nullable();
            $table->string('avatar')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->text('bio')->nullable();
            $table->string('title')->nullable();
            $table->string('state')->nullable();
            $table->string('views')->nullable();
            $table->string('auth_driver')->nullable();
            $table->string('city')->nullable();
            $table->integer('no_of_listings');
            $table->boolean('verified');
            $table->string('phone_number')->nullable();
            $table->integer('no_reviews')->nullable();
            $table->integer('rating')->nullable();
            $table->string('password_reset')->nullable();
            $table->boolean('isVerified');
            $table->string('status');
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
        Schema::dropIfExists('agents');
    }
}
