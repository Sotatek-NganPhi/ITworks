<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInquiriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name');
            $table->string('contact_person_signature')->nullable();
            $table->string('name_person');
            $table->string('job_category');
            $table->string('postal_code');
            $table->string('address');
            $table->string('contact_phone_number');
            $table->string('contact_fax_number')->nullable();
            $table->string('contact_email_address');
            $table->text('content_inquiry');
            $table->text('offering_content')->nullable();
            $table->text('other')->nullable();
            $table->string('desire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * 
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('inquiries'))
        {
            Schema::drop('inquiries');
        }
    }
}
