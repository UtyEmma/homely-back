<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('category');
            $table->string('no_rooms');
            $table->string('features');
            $table->string('amenities');
            $table->string('budget');
            $table->string('state');
            $table->string('lga');
            $table->string('area');
            $table->string('landmark');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('additional');
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
        Schema::dropIfExists('wishlists');
    }
}
