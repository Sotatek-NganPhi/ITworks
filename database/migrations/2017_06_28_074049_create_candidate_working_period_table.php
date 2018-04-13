<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateWorkingPeriodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_working_period', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('working_period_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('working_period_id');
            $table->unique(['candidate_id', 'working_period_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_working_period');
    }
}