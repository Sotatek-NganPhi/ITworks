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
            $table->unsignedInteger('user_id')->unique();
            $table->text('education')->nullable();
            $table->string('final_academic_school')->nullable();
            $table->date('graduated_at')->nullable();
            $table->text('language')->nullable();
            $table->text('language_level')->nullable();
            $table->timestamps();
        });

        // Schema::table('candidates', function($table) {
        //    $table->foreign('user_id')->references('id')->on('users');
        // });
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
