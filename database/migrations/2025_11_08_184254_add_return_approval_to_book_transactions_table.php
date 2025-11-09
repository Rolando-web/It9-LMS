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
        Schema::table('book_transactions', function (Blueprint $table) {
            $table->timestamp('return_requested_at')->nullable()->after('returned_at');
            $table->unsignedBigInteger('return_approved_by')->nullable()->after('approved_by');
            $table->foreign('return_approved_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_transactions', function (Blueprint $table) {
            $table->dropForeign(['return_approved_by']);
            $table->dropColumn(['return_requested_at', 'return_approved_by']);
        });
    }
};
