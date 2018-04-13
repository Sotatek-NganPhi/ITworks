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
            $table->integer('pc_views')->default(0);
            $table->integer('mobile_views')->default(0);
            $table->timestamps();

            // Create indexes
            $table->index('job_id');
            $table->unique(['job_id', 'view_date']);
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
