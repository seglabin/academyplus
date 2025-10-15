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
        Schema::create('localites', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('codelocalite');
            $table->string('libunique');
            $table->unsignedBigInteger('idtypelocalite');
            $table->foreign('idtypelocalite')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idzonesanitaire');
            $table->foreign('idzonesanitaire')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idlocalitemere');
            $table->foreign('idlocalitemere')
                    ->references('id')
                    ->on('localites')
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
        Schema::dropIfExists('localites');
    }
};
