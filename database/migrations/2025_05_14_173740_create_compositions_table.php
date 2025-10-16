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
        Schema::create('compositions', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->date('datecompo');
            $table->Integer('barem');
            $table->unsignedBigInteger('idclassannesco');
            $table->foreign('idclassannesco')
                    ->references('id')
                    ->on('classannescos')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idetat')->nullable();
            $table->foreign('idetat')
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
        Schema::dropIfExists('compositions');
    }
};
