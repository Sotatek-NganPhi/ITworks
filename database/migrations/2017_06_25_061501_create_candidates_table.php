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
            $table->unsignedInteger('user_id')->unique();
            $table->unsignedInteger('education_id')->nullable();
            $table->string('final_academic_school')->nullable();
            $table->date('graduated_at')->nullable();
            $table->float('toeic')->nullable();
            $table->float('toefl')->nullable();
            $table->unsignedInteger('language_experience_id')->nullable();
            $table->unsignedInteger('language_conversation_level_id')->nullable();
            $table->timestamps();
        });

        // Schema::table('candidates', function($table) {
        //    $table->foreign('user_id')->references('id')->on('users');
        //    $table->foreign('education_id')->references('id')->on('educations');
        //    $table->foreign('language_experience_id')->references('id')->on('language_experiences');
        //    $table->foreign('language_conversation_level_id')->references('id')->on('language_conversation_levels');
        // });
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
