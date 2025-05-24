<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('communiques', function (Blueprint $table) {
            $table->boolean('has_attachments')->default(false)->after('is_published');
        });
        
        // Mettre à jour les enregistrements existants
        DB::table('communiques')
            ->whereIn('id', function($query) {
                $query->select('communique_id')
                    ->from('communique_attachments')
                    ->groupBy('communique_id');
            })
            ->update(['has_attachments' => true]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communiques', function (Blueprint $table) {
            $table->dropColumn('has_attachments');
        });
    }
};
