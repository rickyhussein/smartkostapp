<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onUpdate('cascade')->onDelete('cascade');
            $table->string('room_name')->nullable();
            $table->string('room_type')->nullable();
            $table->string('floor')->nullable();
            $table->bigInteger('room_height')->nullable();
            $table->bigInteger('room_width')->nullable();
            $table->bigInteger('one_month_price')->nullable();
            $table->bigInteger('three_month_price')->nullable();
            $table->bigInteger('six_month_price')->nullable();
            $table->bigInteger('twelve_month_price')->nullable();
            $table->bigInteger('deposit_price')->nullable();
            $table->string('room_file_path')->nullable();
            $table->string('room_file_name')->nullable();
            $table->integer('is_available')->nullable();
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
        Schema::dropIfExists('property_rooms');
    }
}
