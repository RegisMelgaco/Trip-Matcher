<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('schedule')->index();
            $table->boolean('mode')->index();
            $table->integer('spaces')->nullable();
            $table->time('end_time');
            $table->string('start_address');
            $table->double('start_address_lat');
            $table->double('start_address_lng');
            $table->string('end_address');
            $table->double('end_address_lat');
            $table->double('end_address_lng');
            $table->string('user_name');
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
        Schema::dropIfExists('trips');
    }
}
