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
        Schema::create('coefficients', function (Blueprint $table) {
            $table->id();
            $table->Integer('coef')->default(1);
            $table->Integer('rang')->nullable();
            $table->unsignedBigInteger('idclasse');
            $table->foreign('idclasse')
                    ->references('id')
                    ->on('classetypes')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idmatiere');
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
        Schema::dropIfExists('coefficients');
    }
};
