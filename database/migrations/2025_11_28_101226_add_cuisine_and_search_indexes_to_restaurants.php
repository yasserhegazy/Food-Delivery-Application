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
        Schema::table('restaurants', function (Blueprint $table) {
            // Add cuisine type column
            $table->string('cuisine_type', 50)->nullable()->after('description');
            
            // Add indexes for search optimization
            $table->index('city');
            $table->index('cuisine_type');
            $table->index('rating');
            $table->index('is_active');
            
            // Composite index for common query patterns
            $table->index(['is_active', 'rating', 'city'], 'restaurants_active_rating_city_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['city']);
            $table->dropIndex(['cuisine_type']);
            $table->dropIndex(['rating']);
            $table->dropIndex(['is_active']);
            $table->dropIndex('restaurants_active_rating_city_index');
            
            // Drop column
            $table->dropColumn('cuisine_type');
        });
    }
};
