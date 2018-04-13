<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobMeritTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_merit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('merit_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('merit_id');
            $table->unique(['job_id', 'merit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_merit');
    }
}
