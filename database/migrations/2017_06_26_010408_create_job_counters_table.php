<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobCountersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_counters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('job_id');
            $table->date('view_date')->nullable();;
            $table->integer('views')->default(0);
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->unique(['job_id', 'view_date']);
        });

        Schema::table('job_counters', function($table) {
           $table->foreign('job_id')->references('id')->on('jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('job_counters');
    }
}
