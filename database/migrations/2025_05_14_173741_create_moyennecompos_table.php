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
        Schema::create('moyennecompos', function (Blueprint $table) {
            $table->id();
            $table->double('m1')->default(-1);
            $table->double('m2')->default(-1);
            $table->double('m3')->default(-1);
            $table->double('m4')->default(-1);
            $table->double('m5')->default(-1);
            $table->double('m6')->default(-1);
            $table->double('m7')->default(-1);
            $table->double('m8')->default(-1);
            $table->double('m9')->default(-1);
            $table->double('m10')->default(-1);
            $table->double('m11')->default(-1);
            $table->double('m12')->default(-1);
            $table->double('moyenne');
            $table->unsignedBigInteger('idinscription');
            $table->foreign('idinscription')
                    ->references('id')
                    ->on('inscriptions')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idcompo');
            $table->foreign('idcompo')
                    ->references('id')
                    ->on('compositions')
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
        Schema::dropIfExists('moyennecompos');
    }
};
