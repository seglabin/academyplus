<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affectations', function (Blueprint $table) {
            $table->id(); //`idenseignant`, `idmatiere`, `idclassannesco`, `dateaffetation`, `datefin`, `desactive`,
            $table->date('dateaffetation');
            $table->date('datefin');
            $table->boolean('desactive')->default(false);
            $table->unsignedBigInteger('idenseignant');
            $table->foreign('idenseignant')
                ->references('id')
                ->on('users')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('idclassannesco');
            $table->foreign('idclassannesco')
                ->references('id')
                ->on('classannescos')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('idmatiere')->nullable();
            $table->foreign('idmatiere')
                ->references('id')
                ->on('matieres')
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
        Schema::dropIfExists('affectations');
    }
};
