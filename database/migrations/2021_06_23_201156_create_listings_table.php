<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('agent_id')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('tenure')->nullable();
            $table->string('duration')->nullable();
            $table->string('type')->nullable();
            $table->string('rent')->nullable();
            $table->string('extra_fees')->nullable();
            $table->string('initial_fees')->nullable();
            $table->string('no_bedrooms')->nullable();
            $table->string('no_bathrooms')->nullable();
            $table->string('no_floors')->nullable();
            $table->string('status')->nullable();
            $table->text('images')->nullable();
            $table->string('video_links')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('landmark')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->text('extra_info')->nullable();
            $table->string('valid_till')->nullable();
            $table->string('reviews')->nullable();
            $table->boolean('rented');
            $table->json('amenities')->nullable();
            $table->string('rating')->nullable();
            $table->integer('views');
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
        Schema::dropIfExists('listings');
    }
}
