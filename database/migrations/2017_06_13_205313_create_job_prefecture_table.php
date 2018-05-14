<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobPrefectureTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_prefecture', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('prefecture_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('prefecture_id');
            $table->unique(['job_id', 'prefecture_id']);
        });

        // Schema::table('job_prefecture', function($table) {
        //    $table->foreign('job_id')->references('id')->on('jobs');
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
        Schema::drop('job_prefecture');
    }
}
