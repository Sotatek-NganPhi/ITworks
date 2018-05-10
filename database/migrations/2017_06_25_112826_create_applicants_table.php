<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateApplicantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->integer('job_id')->unsigned();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthday')->nullable();
            $table->integer('education_id')->unsigned()->nullable();
            $table->string('final_academic_school')->nullable();
            $table->date('graduated_at')->nullable();
            $table->float('toeic')->nullable();
            $table->float('toefl')->nullable();
            $table->integer('language_experience_id')->unsigned()->nullable();
            $table->integer('language_conversation_level_id')->unsigned()->nullable();
            $table->integer('status')->default(0);
            // Create indexes
            $table->index('job_id');
            $table->index('user_id');
            $table->index('email');

            $table->timestamps();
        });

        Schema::table('applicants', function($table) {
           $table->foreign('user_id')->references('id')->on('users');
           $table->foreign('job_id')->references('id')->on('jobs');
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
        Schema::drop('applicants');
    }
}
