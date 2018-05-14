<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateWorkingHourTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_working_hour', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('working_hour_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('working_hour_id');
            $table->unique(['candidate_id', 'working_hour_id']);
        });

        // Schema::table('candidate_working_hour', function($table) {
        //    $table->foreign('candidate_id')->references('id')->on('candidates');
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
        Schema::drop('candidate_working_hour');
    }
}
