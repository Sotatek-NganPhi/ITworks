<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateWorkingShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_working_shift', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('working_shift_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('working_shift_id');
            $table->unique(['candidate_id', 'working_shift_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_working_shift');
    }
}
