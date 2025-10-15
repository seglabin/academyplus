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
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->date('datepaiement');
            $table->double('montant');
            $table->string('deposant');
            $table->unsignedBigInteger('idinscription');
            $table->foreign('idinscription')
                    ->references('id')
                    ->on('inscriptions')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idmotif');
            $table->foreign('idmotif')
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
        Schema::dropIfExists('paiements');
    }
};
