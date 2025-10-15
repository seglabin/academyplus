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
        Schema::create('subventions', function (Blueprint $table) {
            $table->id();
            $table->string('numcompte',20);
            $table->string('agence');
            $table->string('directeur');
            $table->string('contact',20);
            $table->string('numregion',20);
            $table->string('observations');
            $table->string('suggestion');
            $table->date('datesubvention');
            $table->double('totrecette');
            $table->double('totdepense');
            $table->boolean('visible')->default(false);
            $table->unsignedBigInteger('idetat');
            $table->foreign('idetat')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idddemp');
            $table->foreign('idddemp')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idanneescolaire');
            $table->foreign('idanneescolaire')
                    ->references('id')
                    ->on('anneescolaires')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idabonnement');
            $table->foreign('idabonnement')
                    ->references('id')
                    ->on('abonnements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idcirconscolaire');
            $table->foreign('idcirconscolaire')
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
        Schema::dropIfExists('subventions');
    }
};
