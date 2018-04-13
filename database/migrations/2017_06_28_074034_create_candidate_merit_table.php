<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateMeritTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_merit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('merit_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('merit_id');
            $table->unique(['candidate_id', 'merit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_merit');
    }
}
