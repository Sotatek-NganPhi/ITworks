<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobSpecialsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_special', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->integer('special_promotion_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('special_promotion_id');
            $table->unique(['job_id', 'special_promotion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_special');
    }
}
