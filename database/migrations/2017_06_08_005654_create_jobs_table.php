<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateJobsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id');
            $table->text('description')->nullable();
            $table->text('company_name')->nullable();
            $table->date('post_start_date')->nullable();
            $table->date('post_end_date')->nullable();
            $table->enum('original_state', [0, 1])->default(1);
            $table->integer('max_applicant')->nullable();
            $table->text('interns_start_time')->nullable();
            $table->text('working_hours')->nullable();
            $table->text('salary')->nullable();
            $table->text('application_condition')->nullable();
            $table->text('message')->nullable();
            $table->text('holiday_vacation')->nullable();
            $table->text('interview_place')->nullable();
            $table->string('main_image')->nullable();
            $table->string('main_caption')->nullable();
            $table->string('sub_image1')->nullable();
            $table->string('sub_image2')->nullable();
            $table->string('sub_image3')->nullable();
            $table->string('sub_image4')->nullable();
            $table->string('sub_caption1')->nullable();
            $table->string('sub_caption2')->nullable();
            $table->string('sub_caption3')->nullable();
            $table->string('sub_caption4')->nullable();
            $table->string('email_company')->nullable();
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('jobs', function($table) {
           $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('jobs');
    }
}
