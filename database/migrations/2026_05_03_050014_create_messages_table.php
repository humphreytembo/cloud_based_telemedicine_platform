<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            // Make message nullable (file-only messages have no text)
            $table->text('message')->nullable()->change();

            // File attachment path
            $table->string('file')->nullable()->after('message');

            // Read receipt
            $table->boolean('is_read')->default(false)->after('file');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->text('message')->nullable(false)->change();
            $table->dropColumn(['file', 'is_read']);
        });
    }
};