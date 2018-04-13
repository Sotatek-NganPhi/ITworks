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
            $table->boolean('is_married')->default(null)->nullable();
            $table->integer('current_situation_id')->unsigned();
            $table->integer('education_id')->unsigned()->default(null)->nullable();
            $table->string('final_academic_school')->default(null)->nullable();
            $table->date('graduated_at')->default(null)->nullable();
            $table->float('toeic')->nullable();
            $table->float('toefl')->nullable();
            $table->integer('language_experience_id')->unsigned()->nullable();
            $table->integer('language_conversation_level_id')->unsigned()->nullable();
            $table->integer('driver_license_id')->unsigned();
            $table->integer('jumping_condition_id')->unsigned()->nullable();
            $table->integer('jumping_date_id')->unsigned();
            $table->integer('worked_companies_number')->nullable();
            $table->string('lastest_company_name')->nullable();
            $table->integer('lastest_industry_id')->unsigned()->nullable();
            $table->integer('lastest_company_size_id')->unsigned()->nullable();
            $table->float('lastest_annual_income')->nullable();
            $table->integer('lastest_position_id')->unsigned()->nullable();
            $table->integer('lastest_employment_mode_id')->unsigned()->nullable();
            $table->text('lastest_job_description')->nullable();
            $table->integer('platform_flag')->default(0);


            // WEB RESUME
            $table->integer('resume_prefectures_id')->default(null)->nullable();
            $table->string('resume_academic_department')->default(null)->nullable();
            $table->text('resume_academic_achievement')->default(null)->nullable();
            $table->string('resume_qualification')->default(null)->nullable();
            $table->string('resume_recent_employment_industry')->default(null)->nullable();
            $table->string('resume_recent_employment_job')->default(null)->nullable();
            $table->string('resume_recent_employment_period')->default(null)->nullable();
            $table->text('resume_pr')->default(null)->nullable();

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
        Schema::drop('candidates');
    }
}
