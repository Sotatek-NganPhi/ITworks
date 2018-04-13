<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRefEnumValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_enum_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ref_enum_id');
            $table->string('value');
            $table->string('display_name');
            $table->timestamps();

            $table->unique(['ref_enum_id', 'value']);
            $table->unique(['ref_enum_id', 'display_name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_enum_values');
    }
}
