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
        Schema::create('matieres', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('abreviation',20)->nullable();
            $table->boolean('maternel')->default(false);
            $table->boolean('primaire')->default(false);
            $table->boolean('secondaire')->default(false);
            $table->boolean('universitaire')->default(false);
            $table->boolean('autres')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
