<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeNameColumnSearchConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('search_conditions')) {
            Schema::table('search_conditions', function (Blueprint $table) {
                $table->renameColumn('free_work', 'free_word');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('search_conditions')) {
            Schema::table('search_conditions', function (Blueprint $table) {
                $table->dropColumn('free_word');
            });
        }
    }
}
