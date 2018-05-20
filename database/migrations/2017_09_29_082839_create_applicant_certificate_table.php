<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicantCertificateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicant_certificate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('certificate_id')->unsigned();
            $table->integer('applicant_id')->unsigned();
            $table->unique(['applicant_id', 'certificate_id']);
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
        Schema::dropIfExists('applicant_certificate');
    }
}
