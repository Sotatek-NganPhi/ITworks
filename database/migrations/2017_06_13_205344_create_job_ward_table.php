<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobWardTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_ward', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('ward_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('ward_id');
            $table->unique(['job_id', 'ward_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_ward');
    }
}
