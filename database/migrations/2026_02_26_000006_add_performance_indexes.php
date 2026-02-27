<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->index('is_available');
            $table->index('is_featured');
        });

        if (!$this->indexExists('restaurants', 'restaurants_is_active_index')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->index('is_active');
            });
        }

        if (!$this->indexExists('restaurants', 'restaurants_rating_index')) {
            Schema::table('restaurants', function (Blueprint $table) {
                $table->index('rating');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['is_available']);
            $table->dropIndex(['is_featured']);
        });
    }

    private function indexExists(string $table, string $indexName): bool
    {
        try {
            $indexes = Schema::getIndexes($table);
            foreach ($indexes as $index) {
                if ($index['name'] === $indexName) {
                    return true;
                }
            }
        } catch (\Throwable) {
            // Schema::getIndexes not available on this driver
        }
        return false;
    }
};
