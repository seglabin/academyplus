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
        Schema::create('classetypes', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('sigle',10);
            $table->string('secteur',2);
            $table->Integer('niveau');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classetypes');
    }
};
