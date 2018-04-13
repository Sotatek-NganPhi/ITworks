<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveAgenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('agencies');

        if (Schema::hasColumn('jobs', 'agency_id')) {
            Schema::table('jobs', function($table) {
                $table->dropColumn('agency_id');
            });
        }

        if (Schema::hasColumn('companies', 'agency_id')) {
            Schema::table('companies', function($table) {
                $table->dropColumn('agency_id');
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
        //
    }
}
