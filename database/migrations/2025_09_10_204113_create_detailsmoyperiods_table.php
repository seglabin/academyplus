<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    { //`idinscription`,`moyinterro`,int1,int2,int3,int4,int5, `dev1`, `dev2`, `moy`, rang, `appreciation`
        Schema::create('detailsmoyperiods', function (Blueprint $table) {
            $table->id();
            $table->string('appreciation');
            $table->integer('rang');
            $table->double('intero1')->default(-1);
            $table->double('intero2')->default(-1);
            $table->double('intero3')->default(-1);
            $table->double('intero4')->default(-1);
            $table->double('intero5')->default(-1);
            $table->double('dev1')->default(-1);
            $table->double('dev2')->default(-1);
            $table->double('moyinterro')->default(-1);
            $table->double('moy')->default(-1);
            $table->unsignedBigInteger('idmoyperiod');
            $table->foreign('idmoyperiod')
                ->references('id')
                ->on('moyperiodapprenants')
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
        Schema::dropIfExists('detailsmoyperiods');
    }
};
