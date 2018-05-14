<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialPromotionRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_promotion_region', function (Blueprint $table) {
            $table->unsignedInteger('special_promotion_id');
            $table->unsignedInteger('region_id');
            $table->timestamps();
        });

        // Schema::table('special_promotion_region', function($table) {
        //    $table->foreign('region_id')->references('id')->on('regions');
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
        Schema::dropIfExists('special_promotion_region');
    }
}
