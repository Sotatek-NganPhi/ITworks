<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLineStationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('line_stations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('line_id');
            $table->integer('station_id');
            $table->integer('order');
            $table->timestamps();

            // Create indexes
            $table->index('line_id');
            $table->index('station_id');
            $table->unique(['line_id', 'station_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('line_stations');
    }
}
