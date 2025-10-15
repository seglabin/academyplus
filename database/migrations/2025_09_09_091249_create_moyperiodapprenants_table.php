<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    { //`idclassannesco`,`idmatiere`, `idsession`, idetat
        Schema::create('moyperiodapprenants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('idetat')->nullable();
            $table->foreign('idetat')
                ->references('id')
                ->on('elements')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('idsession');
            $table->foreign('idsession')
                ->references('id')
                ->on('sessionacademiques')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('idmatiere');
            $table->foreign('idmatiere')
                ->references('id')
                ->on('matieres')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('idclassannesco');
            $table->foreign('idclassannesco')
                ->references('id')
                ->on('classannescos')
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
        Schema::dropIfExists('moyperiodapprenants');
    }
};
