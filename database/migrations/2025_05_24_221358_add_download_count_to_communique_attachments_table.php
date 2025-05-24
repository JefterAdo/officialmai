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
        Schema::table('communique_attachments', function (Blueprint $table) {
            $table->unsignedBigInteger('download_count')->default(0)->after('mime_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('communique_attachments', function (Blueprint $table) {
            $table->dropColumn('download_count');
        });
    }
};
