<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCandidatesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->unique();
            $table->integer('education_id')->unsigned()->default(null)->nullable();
            $table->string('final_academic_school')->default(null)->nullable();
            $table->date('graduated_at')->default(null)->nullable();
            $table->float('toeic')->nullable();
            $table->float('toefl')->nullable();
            $table->integer('language_experience_id')->unsigned()->nullable();
            $table->integer('language_conversation_level_id')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('candidates', function($table) {
           $table->foreign('user_id')->references('id')->on('users');
           $table->foreign('education_id')->references('id')->on('education');
           $table->foreign('language_experience_id')->references('id')->on('language_experiences');
           $table->foreign('language_conversation_level_id')->references('id')->on('language_conversation_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidates');
    }
}
