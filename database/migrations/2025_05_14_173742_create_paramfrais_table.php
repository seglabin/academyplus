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
        Schema::create('paramfrais', function (Blueprint $table) {
            $table->id();
            $table->double('fraiscolarite')->default(0);
            $table->double('fraisinscrip')->default(0);
            $table->double('fraisreinscrit')->default(0);
            $table->double('trancheinscrip')->default(0);
            $table->double('tranchecheance1')->default(0);
            $table->double('tranchecheance2')->default(0);
            $table->double('tranchecheance3')->default(0);
            $table->double('tranchecheance4')->default(0);
            $table->double('tranchecheance5')->default(0);
            $table->double('tranchecheance6')->default(0);
            $table->double('tranchecheance7')->default(0);
            $table->date('echeance1')->nullable();
            $table->date('echeance2')->nullable();
            $table->date('echeance3')->nullable();
            $table->date('echeance4')->nullable();
            $table->date('echeance5')->nullable();
            $table->date('echeance6')->nullable();
            $table->date('echeance7')->nullable();
            $table->unsignedBigInteger('idannesco');
            $table->foreign('idannesco')
                    ->references('id')
                    ->on('anneescolaires')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idclassetype');
            $table->foreign('idclassetype')
                    ->references('id')
                    ->on('classetypes')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idabonnement');
            $table->foreign('idabonnement')
                    ->references('id')
                    ->on('abonnements')
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
        Schema::dropIfExists('paramfrais');
    }
};
