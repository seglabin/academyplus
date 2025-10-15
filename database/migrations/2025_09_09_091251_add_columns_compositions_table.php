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
        Schema::table('compositions', function (Blueprint $table) {
            $table->unsignedBigInteger('idsession')->nullable();
            $table->foreign('idsession')
                ->references('id')
                ->on('sessionacademiques')
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
