<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->string('url_pc')->nullable()->change();
            $table->string('url_mobile')->nullable()->change();
            $table->string('image_pc')->nullable()->change();
            $table->string('image_mobile')->nullable()->change();
            $table->string('url')->nullable()->after('link_title');
            $table->string('image')->nullable()->after('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropColumn('url');
            $table->dropColumn('image');
        });
    }
}
