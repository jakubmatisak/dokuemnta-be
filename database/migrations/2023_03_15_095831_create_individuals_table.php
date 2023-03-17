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
        Schema::create('individuals', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 50);
            $table->string('surname', 100);
            $table->string('email', 100);
            $table->string('phone', 15);
            $table->integer('id_contact_address')->unsigned()->index()->nullable()->default(null);
            $table->integer('id_billing_address')->unsigned()->index();
            $table->timestamps();
        });

        Schema::table('individuals', function ($table) {
            $table->foreign('id_contact_address')->references('id')->on('addresses')->onDelete('cascade');
            $table->foreign('id_billing_address')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('individuals');
    }
};
