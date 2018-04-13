<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('applicant_id')->index();
            $table->text('content');
            $table->text('title');
            $table->tinyInteger('type')->default(0);
            $table->string('metadata')->nullable();
            $table->enum('from', ['user', 'manager']);
            $table->unsignedInteger('user_id')->index();
            $table->unsignedInteger('manager_id')->index();
            $table->tinyInteger('is_read')->default(0);
            $table->tinyInteger('is_favorite')->default(0);
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
        Schema::dropIfExists('messages');
    }
}
