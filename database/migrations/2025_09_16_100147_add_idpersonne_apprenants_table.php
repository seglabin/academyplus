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
        Schema::table('apprenants', function (Blueprint $table) {
           $table->unsignedBigInteger('idpersonne');
            $table->foreign('idpersonne')
                    ->references('id')
                    ->on('personnes')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
