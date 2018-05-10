<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateWorkingDayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_working_day', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('working_day_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('working_day_id');
            $table->unique(['candidate_id', 'working_day_id']);
        });

        Schema::table('candidate_working_day', function($table) {
           $table->foreign('candidate_id')->references('id')->on('candidates');
           $table->foreign('working_day_id')->references('id')->on('working_days');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_working_day');
    }
}
