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
        Schema::table('categories', function (Blueprint $table) {
            $table->string('why_title')->nullable()->after('description');
            $table->text('why_text')->nullable()->after('why_title');
            $table->string('gift_title')->nullable()->after('why_text');
            $table->text('gift_text')->nullable()->after('gift_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['why_title', 'why_text', 'gift_title', 'gift_text']);
        });
    }
};
