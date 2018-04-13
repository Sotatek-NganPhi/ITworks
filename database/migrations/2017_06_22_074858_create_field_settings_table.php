<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFieldSettingsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name');
            $table->string('field_name');
            $table->string('display_name');
            $table->string('reference');
            $table->integer('input_method')->default(1);
            $table->string('description')->nullable();
            $table->integer('emoji')->default(0);
            $table->boolean('is_required')->default(false);
            $table->boolean('is_list_display')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['table_name', 'field_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('field_settings');
    }
}
