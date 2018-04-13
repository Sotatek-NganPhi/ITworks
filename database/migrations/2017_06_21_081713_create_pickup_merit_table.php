<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePickupMeritTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_merit', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pickup_id');
            $table->integer('merit_id');
            $table->timestamps();

            // Create indexes
            $table->index('pickup_id');
            $table->index('merit_id');
            $table->unique(['pickup_id', 'merit_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pickup_merit');
    }
}
