<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    { //libelle, idsecteur, rang
        Schema::create('sessionacademiques', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->integer('rang');
            $table->unsignedBigInteger('idsecteur');
            $table->foreign('idsecteur')
                ->references('id')
                ->on('secteurs')
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
        Schema::dropIfExists('sessionacademiques');
    }
};
