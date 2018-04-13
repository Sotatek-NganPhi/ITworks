<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateCurrentSituationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_current_situation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('current_situation_id')->unsigned();
            $table->integer('candidate_id')->unsigned();
            $table->timestamps();
            $table->index('candidate_id');
            $table->index('current_situation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_current_situation');
    }
}
