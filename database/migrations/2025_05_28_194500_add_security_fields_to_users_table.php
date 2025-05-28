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
        Schema::table('users', function (Blueprint $table) {
            // Champs pour la journalisation des connexions
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            
            // Champs pour le verrouillage de compte
            $table->timestamp('locked_until')->nullable();
            $table->string('lock_reason')->nullable();
            
            // Champs pour la sécurité supplémentaire
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('password_changed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'last_login_at',
                'last_login_ip',
                'locked_until',
                'lock_reason',
                'failed_login_attempts',
                'password_changed_at'
            ]);
        });
    }
};
