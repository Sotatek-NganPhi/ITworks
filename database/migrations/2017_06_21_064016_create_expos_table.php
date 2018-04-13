<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expos', function (Blueprint $table) {
            $table->increments('id');
            $table->datetime('date');
            $table->string('organizer_name');
            $table->string('time');
            $table->datetime('start_date')->nullable();
            $table->datetime('end_date')->nullable();
            $table->string('presentation_name');
            $table->text('address');
            $table->text('content');
            $table->text('pr')->nullable();
            $table->text('map_url');
            $table->string('cs_email');
            $table->text('cs_phone')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expos');
    }
}
