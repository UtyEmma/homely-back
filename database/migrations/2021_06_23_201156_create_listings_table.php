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
            $table->string('category')->nullable();
            $table->string('agent_id');
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('tenure')->nullable();
            $table->string('initial_price')->nullable();
            $table->string('duration')->nullable();
            $table->string('type')->nullable();
            $table->string('agency_fees')->nullable();
            $table->string('legal_fees')->nullable();
            $table->string('caution_fees')->nullable();
            $table->string('status')->nullable();
            $table->string('images')->nullable();
            $table->string('video_links')->nullable();
            $table->string('virtual_tour')->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('landmark')->nullable();
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->json('details')->nullable();
            $table->json('features')->nullable();
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
