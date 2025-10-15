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
        Schema::create('comptesubventions', function (Blueprint $table) {
            $table->id();
            $table->string('chapitre',5);
            $table->string('numcompte',20);
            $table->string('typecompte',20);
            $table->string('intitule');
            $table->boolean('visible')->default(false);
            $table->unsignedBigInteger('idparent')->nullable();
            $table->foreign('idparent')
                    ->references('id')
                    ->on('comptesubventions')
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
        Schema::dropIfExists('comptesubventions');
    }
};
