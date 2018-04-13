<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateExpoRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expo_region', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('expo_id')->index();
            $table->unsignedInteger('region_id');
            $table->unique(['expo_id', 'region_id']);
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
        Schema::dropIfExists('expo_region');
    }
}
