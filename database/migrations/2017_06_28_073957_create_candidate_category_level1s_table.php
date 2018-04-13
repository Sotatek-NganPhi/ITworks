<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateCategoryLevel1sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_category_level1', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('candidate_id');
            $table->integer('category_level1_id');
            $table->timestamps();

            // Create indexes
            $table->index('candidate_id');
            $table->index('category_level1_id');
            $table->unique(['candidate_id', 'category_level1_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_category_level1');
    }
}
