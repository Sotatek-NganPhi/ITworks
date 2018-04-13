<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToSpecialPromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('special_promotions', function (Blueprint $table) {
            $table->string('image')->nullable()->after('name');
            $table->string('image_pc')->nullable()->change();
            $table->string('image_mobile')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('special_promotions', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
}
