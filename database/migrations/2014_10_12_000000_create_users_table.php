<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('name_phonetic')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('first_name_phonetic')->nullable();
            $table->string('last_name_phonetic')->nullable();
            $table->char('postal_code', 8)->nullable();
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('line_id')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->dateTime('birthday')->nullable();
            $table->boolean('mail_receivable')->default(0);
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}