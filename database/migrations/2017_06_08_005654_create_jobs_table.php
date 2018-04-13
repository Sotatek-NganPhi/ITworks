<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatejobsTable extends Migration
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
            $table->string('work_no')->nullable();
            $table->integer('agency_id')->default(1);
            $table->integer('company_id');
            $table->text('description')->nullable();
            $table->text('company_name')->nullable();
            $table->string('post_type')->nullable();
            $table->date('post_start_date')->nullable();
            $table->date('post_end_date')->nullable();
            $table->enum('original_state', [0, 1])->default(1);
            $table->integer('max_applicant')->nullable();
            $table->text('interns_start_time')->nullable();
            $table->text('work_main')->nullable();
            $table->text('working_hours')->nullable();
            $table->text('seniors_hometown')->nullable();
            $table->text('salary')->nullable();
            $table->text('application_condition')->nullable();
            $table->text('message')->nullable();
            $table->text('holiday_vacation')->nullable();
            $table->text('interview_place')->nullable();
            $table->string('receptionist')->nullable();
            $table->text('option_1')->nullable();
            $table->text('option_2')->nullable();
            $table->text('option_3')->nullable();
            $table->text('option_4')->nullable();
            $table->text('option_5')->nullable();
            $table->text('option_6')->nullable();
            $table->text('option_7')->nullable();
            $table->text('option_8')->nullable();
            $table->text('option_9')->nullable();
            $table->text('option_10')->nullable();
            $table->text('option_11')->nullable();
            $table->text('option_12')->nullable();
            $table->text('option_13')->nullable();
            $table->text('option_14')->nullable();
            $table->text('option_15')->nullable();
            $table->text('option_16')->nullable();
            $table->text('option_17')->nullable();
            $table->text('option_18')->nullable();
            $table->text('option_19')->nullable();
            $table->text('option_20')->nullable();
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
            $table->string('email_receive_applicant')->nullable();
            $table->string('email_company')->nullable();
            $table->string('sales_person_mail')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('automatic_reply_mail_status', [0, 1])->default(0);
            $table->text('automatic_reply_mail_content')->nullable();
            $table->integer('platform_urgent')->default(0);
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
        Schema::drop('jobs');
    }
}
