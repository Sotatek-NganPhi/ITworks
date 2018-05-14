<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatePrefectureTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_prefecture', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('candidate_id');
            $table->unsignedInteger('prefecture_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('prefecture_id');
            $table->unique(['candidate_id', 'prefecture_id']);
        });

        // Schema::table('candidate_prefecture', function($table) {
        //    $table->foreign('candidate_id')->references('id')->on('candidates');
        //    $table->foreign('prefecture_id')->references('id')->on('prefectures');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_prefecture');
    }
}
