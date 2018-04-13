<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoryLevel1JobTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_category_level1', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('category_level1_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('category_level1_id');
            $table->unique(['job_id', 'category_level1_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_category_level1');
    }
}
