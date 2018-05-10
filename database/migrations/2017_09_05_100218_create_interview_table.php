<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInterviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->longText('content');
            $table->string('sub_content');
            $table->date('post_start_date');
            $table->date('post_end_date');
            $table->date('date');
            $table->increments('company_id');
            $table->string('company_name');
            $table->longText('company_description');
            $table->integer('category_interview_id')->unsigned();
            $table->timestamps();
        });

        Schema::table('interviews', function($table) {
           $table->foreign('category_interview_id')->references('id')->on('category_interview');
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
        Schema::dropIfExists('interviews');
    }
}
