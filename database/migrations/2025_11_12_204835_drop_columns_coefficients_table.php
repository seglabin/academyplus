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
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('coefficients', function (Blueprint $table) {
            // 1. Supprimez d'abord la clé étrangère
            $table->dropForeign(['idabonnement']);
            // $table->dropForeign('posts_product_id_foreign'); // Autre syntaxe possible avec le nom de la contrainte
            
            // 2. Ensuite, supprimez la colonne
            $table->dropColumn('idabonnement');
        });
    }
};
