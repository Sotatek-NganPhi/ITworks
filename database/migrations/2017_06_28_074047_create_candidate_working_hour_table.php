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
            $table->integer('candidate_id');
            $table->integer('working_hour_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('working_hour_id');
            $table->unique(['candidate_id', 'working_hour_id']);
        });
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
