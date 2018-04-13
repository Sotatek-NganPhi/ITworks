<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobRoutesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_routes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('line_station_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('line_station_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_routes');
    }
}
