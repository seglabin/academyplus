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
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->date('dateinscrip');
            $table->double('reduction');
            $table->boolean('reinscription')->default(false);
            $table->unsignedBigInteger('idclassannesco');
            $table->foreign('idclassannesco')
                    ->references('id')
                    ->on('classannescos')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idapprenant');
            $table->foreign('idapprenant')
                    ->references('id')
                    ->on('apprenants')
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
        Schema::dropIfExists('inscriptions');
    }
};
