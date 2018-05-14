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
            $table->unsignedInteger('job_id');
            $table->unsignedInteger('special_promotion_id');
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->index('special_promotion_id');
            $table->unique(['job_id', 'special_promotion_id']);
        });

        // Schema::table('job_special', function($table) {
        //    $table->foreign('job_id')->references('id')->on('jobs');
        //    $table->foreign('special_promotion_id')->references('id')->on('special_promotions');
        // });
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
