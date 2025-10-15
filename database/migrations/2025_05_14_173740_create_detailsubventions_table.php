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
        Schema::create('detailsubventions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->double('montant');
            $table->unsignedBigInteger('idsubvention');
            $table->foreign('idsubvention')
                    ->references('id')
                    ->on('subventions')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idcompte');
            $table->foreign('idcompte')
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
        Schema::dropIfExists('detailsubventions');
    }
};
