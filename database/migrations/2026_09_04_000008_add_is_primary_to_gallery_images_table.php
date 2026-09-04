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
        if (Schema::hasTable('gallery_images') && !Schema::hasColumn('gallery_images', 'is_primary')) {
            Schema::table('gallery_images', function (Blueprint $table) {
                $table->boolean('is_primary')->default(false)->after('image_url');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('gallery_images') && Schema::hasColumn('gallery_images', 'is_primary')) {
            Schema::table('gallery_images', function (Blueprint $table) {
                $table->dropColumn('is_primary');
            });
        }
    }
};
