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
            $table->integer('employment_mode_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('prefecture_id')->nullable();
            $table->integer('ward_id')->nullable();
            $table->integer('route_id')->nullable();
            $table->integer('station_id')->nullable();
            $table->string('free_work')->nullable();
            $table->string('merits')->nullable();
            $table->string('key_region')->nullable();
            $table->timestamps();

            // Create indexes
            $table->index('user_id');
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
