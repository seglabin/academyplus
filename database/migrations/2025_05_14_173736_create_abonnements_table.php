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
        Schema::create('abonnements', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('designation');
            $table->string('contact',20);
            $table->string('logo')->nullable();
            $table->date('datexpiration');
            $table->unsignedBigInteger('idetat');
            $table->foreign('idetat')
                    ->references('id')
                    ->on('elements')
                    ->onDelete('restrict')
                    ->onUpdate('restrict');
            $table->unsignedBigInteger('idlocalite');
            $table->foreign('idlocalite')
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
        Schema::dropIfExists('abonnements');
    }
};
