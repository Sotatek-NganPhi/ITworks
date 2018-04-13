<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCandidateEmploymentModeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_employment_mode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employment_mode_id')->unsigned();
            $table->integer('candidate_id')->unsigned();
            $table->timestamps();
            $table->unique(['candidate_id', 'employment_mode_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_employment_mode');
    }
}
