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
            $table->integer('candidate_id');
            $table->integer('prefecture_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('prefecture_id');
            $table->unique(['candidate_id', 'prefecture_id']);
        });
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
