<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePrefecturesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefectures', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('region_id');
            $table->string('name');
            $table->timestamps();

            // Create indexes
            $table->index('region_id');
        });

        // Schema::table('prefectures', function($table) {
        //    $table->foreign('region_id')->references('id')->on('regions');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('prefectures');
    }
}
