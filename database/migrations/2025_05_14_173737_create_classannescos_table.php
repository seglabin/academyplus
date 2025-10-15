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
        Schema::create('classannescos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idabonnement');
            $table->foreign('idabonnement')
                    ->references('id')
                    ->on('abonnements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idclasse');
            $table->foreign('idclasse')
                    ->references('id')
                    ->on('classetypes')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idanneescolaire');
            $table->foreign('idanneescolaire')
                    ->references('id')
                    ->on('anneescolaires')
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
        Schema::dropIfExists('classannescos');
    }
};
