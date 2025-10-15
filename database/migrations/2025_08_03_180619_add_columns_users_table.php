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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('idtypuser')->nullable();
            $table->foreign('idtypuser')
                ->references('id')
                ->on('elements')
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
