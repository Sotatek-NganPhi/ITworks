<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobWorkingHourTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_working_hour', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('working_hour_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('working_hour_id');
            $table->unique(['job_id', 'working_hour_id']);
        });

        // Schema::table('job_working_hour', function($table) {
        //    $table->foreign('job_id')->references('id')->on('jobs');
        //    $table->foreign('working_hour_id')->references('id')->on('working_hours');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_working_hour');
    }
}
