<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobSalaryTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_salary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('salary_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('salary_id');
            $table->unique(['job_id', 'salary_id']);
        });

        Schema::table('job_salary', function($table) {
           $table->foreign('job_id')->references('id')->on('jobs');
           $table->foreign('salary_id')->references('id')->on('salaries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_salary');
    }
}
