<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCandidateCompanySizeTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_company_size', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_size_id')->unsigned();
            $table->integer('candidate_id')->unsigned();
            $table->timestamps();
            $table->unique(['candidate_id', 'company_size_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('candidate_company_size');
    }
}
