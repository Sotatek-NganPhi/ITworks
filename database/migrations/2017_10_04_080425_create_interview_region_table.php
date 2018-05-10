<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_region', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('interview_id')->index();
            $table->unsignedInteger('region_id');
            $table->unique(['interview_id', 'region_id']);
            $table->timestamps();
        });

        Schema::table('interview_region', function($table) {
           $table->foreign('interview_id')->references('id')->on('interview');
           $table->foreign('region_id')->references('id')->on('regions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interview_region');
    }
}
