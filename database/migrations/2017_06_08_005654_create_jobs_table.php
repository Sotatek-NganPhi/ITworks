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
            $table->unsignedInteger('company_id');
            $table->text('company_name')->nullable();
            $table->text('description')->nullable();
            $table->date('post_start_date')->nullable();
            $table->date('post_end_date')->nullable();
            $table->integer('max_applicant')->nullable();
            $table->text('salary')->nullable();
            $table->text('education')->nullable();
            $table->text('language')->nullable();
            $table->text('language_level')->nullable();
            $table->text('application_condition')->nullable();
            $table->text('message')->nullable();
            $table->string('main_image')->nullable();
            $table->string('main_caption')->nullable();
            $table->string('email_receive_applicant')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Schema::table('jobs', function($table) {
        //    $table->foreign('company_id')->references('id')->on('companies');
        // });
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
