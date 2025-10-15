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
        Schema::table('classannescos', function (Blueprint $table) {
            $table->string('groupe',20)->after('idanneescolaire')->nullable();
            $table->integer('nbF')->after('groupe')->default(0);
            $table->integer('nbG')->after('nbF')->default(0);
            
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
