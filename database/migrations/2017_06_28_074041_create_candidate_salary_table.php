<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateSalaryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_salary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('salary_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('salary_id');
            $table->unique(['candidate_id', 'salary_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_salary');
    }
}
