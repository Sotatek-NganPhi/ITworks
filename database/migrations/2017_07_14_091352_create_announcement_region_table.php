<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnnouncementRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcement_region', function (Blueprint $table) {
          $table->increments('id');
            $table->integer('announcement_id');
            $table->integer('region_id');
            $table->timestamps();

            // Create indexes
            $table->index('announcement_id');
            $table->index('region_id');
            $table->unique(['announcement_id', 'region_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
          Schema::drop('announcement_region');
    }
}