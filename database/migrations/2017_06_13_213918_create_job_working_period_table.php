<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobWorkingPeriodTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_working_period', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('working_period_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('working_period_id');
            $table->unique(['job_id', 'working_period_id']);
        });

        Schema::table('job_working_period', function($table) {
           $table->foreign('job_id')->references('id')->on('jobs');
           $table->foreign('working_period_id')->references('id')->on('working_periods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_working_period');
    }
}
