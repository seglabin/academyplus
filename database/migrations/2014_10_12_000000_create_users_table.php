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
        Schema::create('users', function (Blueprint $table) {
            $table->id();        
            $table->string('contact',20);
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('login',255)->unique()->nullable();
            $table->dateTime('password_changed_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('statut')->default(true);
            $table->index('login');
            $table->rememberToken();
			$table->unsignedBigInteger('idrole');
			$table->foreign('idrole')
					->references('id')
					->on('roles')
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
        Schema::dropIfExists('users');
    }
};
