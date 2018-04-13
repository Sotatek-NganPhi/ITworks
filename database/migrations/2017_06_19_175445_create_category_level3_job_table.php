<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryLevel3JobTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_category_level3', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('category_level3_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('category_level3_id');
            $table->unique(['job_id', 'category_level3_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_category_level3');
    }
}
