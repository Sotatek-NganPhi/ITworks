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
            $table->integer('job_id');
            $table->integer('prefecture_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('prefecture_id');
            $table->unique(['job_id', 'prefecture_id']);
        });
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
