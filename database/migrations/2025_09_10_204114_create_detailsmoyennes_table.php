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
        Schema::create('detailsmoyennes', function (Blueprint $table) {
            $table->id();
            $table->string('appreciation');
            $table->integer('rang');
            $table->integer('coef1');
            $table->integer('coef2');
            $table->integer('coef3');
            $table->integer('coef4');
            $table->integer('coef5');
            $table->integer('coef6');
            $table->double('moy1')->default(-1);
            $table->double('moy2')->default(-1);
            $table->double('moy3')->default(-1);
            $table->double('moy4')->default(-1);
            $table->double('moy5')->default(-1);
            $table->double('moy6')->default(-1);
            $table->double('moyannuelle')->default(-1);
            $table->unsignedBigInteger('idmoyenne');
            $table->foreign('idmoyenne')
                ->references('id')
                ->on('moyennes')
                ->onDelete('restrict')
                ->onUpdate('restrict');
            $table->unsignedBigInteger('idinscription');
            $table->foreign('idinscription')
                ->references('id')
                ->on('inscriptions')
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
        Schema::dropIfExists('detailsmoyennes');
    }
};
