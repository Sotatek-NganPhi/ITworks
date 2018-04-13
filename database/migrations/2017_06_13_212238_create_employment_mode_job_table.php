<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmploymentModeJobTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_employment_mode', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('employment_mode_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('employment_mode_id');
            $table->unique(['job_id', 'employment_mode_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_employment_mode');
    }
}
