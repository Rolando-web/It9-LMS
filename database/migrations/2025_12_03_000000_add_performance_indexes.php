<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add indexes for better query performance
     */
    public function up(): void
    {
        // Books table indexes
        Schema::table('books', function (Blueprint $table) {
            $table->index('category', 'idx_books_category');
            $table->index('author', 'idx_books_author');
            $table->index('created_at', 'idx_books_created_at');
            $table->index('user_id', 'idx_books_user_id');
        });

        // Book transactions indexes
        Schema::table('book_transactions', function (Blueprint $table) {
            $table->index('user_id', 'idx_transactions_user_id');
            $table->index('book_id', 'idx_transactions_book_id');
            $table->index('status', 'idx_transactions_status');
            $table->index('borrowed_at', 'idx_transactions_borrowed_at');
            $table->index('due_date', 'idx_transactions_due_date');
            $table->index('returned_at', 'idx_transactions_returned_at');
            $table->index(['user_id', 'status'], 'idx_transactions_user_status');
            $table->index(['book_id', 'status'], 'idx_transactions_book_status');
        });

        // Activity logs indexes
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->index('user_id', 'idx_activity_logs_user_id');
            $table->index('created_at', 'idx_activity_logs_created_at');
            $table->index('action', 'idx_activity_logs_action');
        });

        // Notifications indexes
        Schema::table('notifications', function (Blueprint $table) {
            $table->index('user_id', 'idx_notifications_user_id');
            $table->index('is_read', 'idx_notifications_is_read');
            $table->index('created_at', 'idx_notifications_created_at');
            $table->index(['user_id', 'is_read'], 'idx_notifications_user_read');
        });

        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('role', 'idx_users_role');
            $table->index('created_at', 'idx_users_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropIndex('idx_books_category');
            $table->dropIndex('idx_books_author');
            $table->dropIndex('idx_books_created_at');
            $table->dropIndex('idx_books_user_id');
        });

        Schema::table('book_transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_user_id');
            $table->dropIndex('idx_transactions_book_id');
            $table->dropIndex('idx_transactions_status');
            $table->dropIndex('idx_transactions_borrowed_at');
            $table->dropIndex('idx_transactions_due_date');
            $table->dropIndex('idx_transactions_returned_at');
            $table->dropIndex('idx_transactions_user_status');
            $table->dropIndex('idx_transactions_book_status');
        });

        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropIndex('idx_activity_logs_user_id');
            $table->dropIndex('idx_activity_logs_created_at');
            $table->dropIndex('idx_activity_logs_action');
        });

        Schema::table('notifications', function (Blueprint $table) {
            $table->dropIndex('idx_notifications_user_id');
            $table->dropIndex('idx_notifications_is_read');
            $table->dropIndex('idx_notifications_created_at');
            $table->dropIndex('idx_notifications_user_read');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role');
            $table->dropIndex('idx_users_created_at');
        });
    }
};
