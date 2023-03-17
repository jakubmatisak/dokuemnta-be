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
        Schema::create('offices', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('id_legal_person')->unsigned()->index();
            $table->integer('id_office')->unsigned()->index();
            $table->timestamps();
        });

        Schema::table('offices', function ($table) {
            $table->foreign('id_legal_person')->references('id')->on('legal_people')->onDelete('cascade');
            $table->foreign('id_office')->references('id')->on('legal_people')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
