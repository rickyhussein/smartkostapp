<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyRoomPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_room_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->foreign('property_id')->references('id')->on('properties')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('room_id')->nullable();
            $table->foreign('room_id')->references('id')->on('property_rooms')->onUpdate('cascade')->onDelete('cascade');
            $table->string('room_photo_file_path')->nullable();
            $table->string('room_photo_file_name')->nullable();
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
        Schema::dropIfExists('property_room_photos');
    }
}
