<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('agency_id');
            $table->string('name');
            $table->string('name_phonetic')->nullable();
            $table->string('street_address')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('short_description')->nullable();
            $table->text('option_first_company')->nullable();
            $table->text('option_second_company')->nullable();
            $table->text('option_third_company')->nullable();
            $table->text('business_content')->nullable();
            $table->string('company_hp')->nullable();
            $table->datetime('expire_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Create indexes
            $table->index('agency_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
