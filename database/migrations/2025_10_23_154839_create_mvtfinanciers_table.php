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
        Schema::create('mvtfinanciers', function (Blueprint $table) {
            $table->id();
            $table->dateTime('datemvt');
            $table->string('typemvt',1);
            $table->string('reference',150)->nullable();
            $table->double('montant');
            $table->unsignedBigInteger('idpayeur');
            $table->string('payeur',50);
            $table->unsignedBigInteger('idmotif');
            $table->foreign('idmotif')
                ->references('id')
                ->on('elements')
                ->onDelete('restrict')
                ->onUpdate('restrict');            
            $table->unsignedBigInteger('idabonnement');
            $table->foreign('idabonnement')
                ->references('id')
                ->on('abonnements')
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
        Schema::dropIfExists('mvtfinanciers');
    }
};
