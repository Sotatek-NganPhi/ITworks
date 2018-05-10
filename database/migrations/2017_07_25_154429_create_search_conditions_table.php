<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSearchConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('search_conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->integer('prefecture_id')->nullable();
            $table->string('free_word')->nullable();
            $table->string('key_region')->nullable();
            $table->timestamps();

            // Create indexes
            $table->index('user_id');
        });

        Schema::table('search_conditions', function($table) {
           $table->foreign('user_id')->references('id')->on('users');
           $table->foreign('prefecture_id')->references('id')->on('prefectures');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('search_conditions');
    }
}
