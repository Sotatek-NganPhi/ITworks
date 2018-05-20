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

            $table->unsignedInteger('user_id')->unsigned();
            $table->unsignedInteger('job_id')->unsigned();
            $table->string('email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('birthday')->nullable();
            $table->text('education')->nullable();
            $table->string('final_academic_school')->nullable();
            $table->date('graduated_at')->nullable();
            $table->text('language')->nullable();
            $table->text('language_level')->nullable();
            $table->integer('status')->default(0);
            // Create indexes
            $table->index('job_id');
            $table->index('user_id');
            $table->index('email');

            $table->timestamps();
        });

        // Schema::table('applicants', function($table) {
        //    $table->foreign('user_id')->references('id')->on('users');
        //    $table->foreign('job_id')->references('id')->on('jobs');
        // });
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
