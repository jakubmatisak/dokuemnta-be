<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('legal_people', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50);
            $table->string('registration_number', 10);
            $table->string('tin', 10);
            $table->string('vat_number', 12);
            $table->integer('id_contact_address')->unsigned()->index()->nullable()->default(null);
            $table->integer('id_billing_address')->unsigned()->index();
            $table->timestamps();
        });

        Schema::table('legal_people', function ($table) {
            $table->foreign('id_contact_address')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('id_billing_address')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_persons');
    }
};
