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
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('password')->nullable();
            $table->string('profile_photo')->nullable();
            $table->string('ktp_number')->nullable();
            $table->string('ktp_photo')->nullable();
            $table->string('self_ktp_photo')->nullable();
            $table->string('kk_photo')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('gender')->nullable();
            $table->date('born_date')->nullable();
            $table->string('job')->nullable();
            $table->string('job_desc')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('province_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('district_id')->nullable();
            $table->foreignId('village_id')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('status')->nullable();
            $table->string('last_education')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->bigInteger('balance')->nullable();
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
