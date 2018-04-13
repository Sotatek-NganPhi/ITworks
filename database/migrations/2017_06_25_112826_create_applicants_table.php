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
            $table->string('first_name_phonetic')->nullable();
            $table->string('last_name_phonetic')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthday')->nullable();

            $table->integer('current_situation_id')->unsigned()->nullable();
            $table->integer('education_id')->unsigned()->nullable();
            $table->string('final_academic_school')->nullable();
            $table->date('graduated_at')->nullable();
            $table->float('toeic')->nullable();
            $table->float('toefl')->nullable();
            $table->integer('language_experience_id')->unsigned()->nullable();
            $table->integer('language_conversation_level_id')->unsigned()->nullable();
            $table->integer('driver_license_id')->unsigned();
            $table->integer('worked_companies_number')->nullable();
            $table->integer('lastest_position_id')->nullable();
            $table->integer('lastest_industry_id')->unsigned()->nullable();
            $table->float('lastest_annual_income')->nullable();
            $table->string('lastest_company_name')->nullable();
            $table->text('lastest_job_description')->nullable();
            $table->text('resume_pr')->nullable();
            $table->integer('status')->default(0);
            $table->integer('lastest_employment_mode_id')->unsigned()->nullable();
            $table->boolean('is_married')->nullable();
            // Create indexes
            $table->index('job_id');
            $table->index('user_id');
            $table->index('email');

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
        Schema::drop('applicants');
    }
}
