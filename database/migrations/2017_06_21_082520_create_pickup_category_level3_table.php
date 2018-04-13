<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePickupCategoryLevel3Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_category_level3', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pickup_id');
            $table->integer('category_level3_id');
            $table->timestamps();

            // Create indexes
            $table->index('pickup_id');
            $table->index('category_level3_id');
            $table->unique(['pickup_id', 'category_level3_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pickup_category_level3');
    }
}
