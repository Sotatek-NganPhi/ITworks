<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpoReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expo_reservations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('expo_id')->index();
            $table->string('surname');
            $table->string('name');
            $table->string('full_name');
            $table->string('surname_phonetic');
            $table->string('name_phonetic');
            $table->string('full_name_phonetic');
            $table->integer('gender');
            $table->string('email');
            $table->unsignedInteger('current_situation_id');
            $table->string('phone_number');
            $table->boolean('agreed_to_policy');
            $table->unique(['email', 'expo_id']);
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
        Schema::dropIfExists('expo_reservations');
    }
}
