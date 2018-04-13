<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefTablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_tables', function (Blueprint $table) {
            $table->increments('id');
            $table->string('table_name');
            $table->string('field_value');
            $table->string('field_display_name');
            $table->string('custom_display_name');
            $table->string('filter_condition');
            $table->timestamps();

            $table->unique(['table_name', 'field_value', 'field_display_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_tables');
    }
}
