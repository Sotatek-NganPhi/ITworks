<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidateCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_certificate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certificate_id')->unsigned();
            $table->integer('candidate_id')->unsigned();
            $table->timestamps();
            $table->unique(['candidate_id', 'certificate_id']);
        });

        Schema::table('candidate_certificate', function($table) {
           $table->foreign('certificate_id')->references('id')->on('certificates');
           $table->foreign('candidate_id')->references('id')->on('candidates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidate_certificate');
    }
}
