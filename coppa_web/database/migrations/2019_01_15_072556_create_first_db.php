<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirstDb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Create table: users
         */
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->text('password');
            $table->string('email');
            $table->unsignedInteger('level');
            $table->rememberToken();
            $table->timestamps();
        });

         /**
         * Create table: captains
         */
        Schema::create('captains', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('phone');
            $table->string('vessel');
            $table->timestamps();
        });

        /**
         * Create table: families (loài)
         */
        Schema::create('families', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        /**
         * Create table: fishes (phân loại từ loài)
         */
        Schema::create('fishes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image')->nullable();
            $table->timestamps();
        });

        /**
         * Create table: trip (chuyến đi)
         */
        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->string('from_date');
            $table->string('to_date');
            $table->string('description')->nullable();
            $table->timestamps();
        });

         /**
         * Create table: record (thông tin lưu trữ )
         */
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('fish_id');
            $table->string('long');
            $table->string('weigth');
            $table->string('lat');
            $table->string('lng');
            $table->text('images');
            $table->time('catched_at');
            $table->timestamps();
        });

        /**
         * Create table: family_fish
         */
        Schema::create('family_fish', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('family_id')->unsigned()->index();
            $table->foreign('family_id')->references('id')->on('families')->onDelete('cascade');
            $table->integer('fish_id')->unsigned()->index();
            $table->foreign('fish_id')->references('id')->on('fishes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('record_trip', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('record_id')->unsigned()->index();
            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
            $table->integer('trip_id')->unsigned()->index();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('captain_trip', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('captain_id')->unsigned()->index();
            $table->foreign('captain_id')->references('id')->on('captains')->onDelete('cascade');
            $table->integer('trip_id')->unsigned()->index();
            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
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
        Schema::dropIfExists('captains');
        Schema::dropIfExists('families');
        Schema::dropIfExists('fishes');
        Schema::dropIfExists('family_fish');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('records');
        Schema::dropIfExists('record_trip');
        Schema::dropIfExists('captain_trip');
    }
}
