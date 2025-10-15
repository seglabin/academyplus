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
        Schema::create('personnes', function (Blueprint $table) {
            $table->id();
            $table->string('npi',50);
            $table->string('nom');
            $table->string('prenoms');
            $table->date('datenais')->nullable();
            $table->string('lieunais')->nullable();
            $table->string('contactparent',20);
            $table->string('photo')->nullable();
            $table->unsignedBigInteger('idsexe')->nullable();
            $table->foreign('idsexe')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idnationalite')->nullable();
            $table->foreign('idnationalite')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personnes');
    }
};
