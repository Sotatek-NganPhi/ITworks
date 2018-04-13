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
            $table->string('picture');
            $table->string('thumbnail');
            $table->longText('content');
            $table->string('sub_content');
            $table->date('post_start_date');
            $table->date('post_end_date');
            $table->date('date');
            $table->string('interviewer');
            $table->string('company_name');
            $table->longText('company_description');
            $table->string('company_url');
            $table->integer('category_interview_id')->unsigned();
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
        Schema::dropIfExists('interviews');
    }
}
