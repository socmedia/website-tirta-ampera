<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to create the cache and cache_locks tables.
     */
    public function up(): void
    {
        // Create the 'cache' table to store cached items
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary(); // Unique key for the cached item
            $table->mediumText('value'); // The value of the cached item
            $table->integer('expiration'); // Expiration time for the cached item in seconds
        });

        // Create the 'cache_locks' table to manage cache locks
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary(); // Unique key for the cache lock
            $table->string('owner'); // Owner of the cache lock
            $table->integer('expiration'); // Expiration time for the cache lock in seconds
        });
    }

    /**
     * Reverse the migrations to drop the cache and cache_locks tables.
     */
    public function down(): void
    {
        // Drop the 'cache' table if it exists
        Schema::dropIfExists('cache');
        // Drop the 'cache_locks' table if it exists
        Schema::dropIfExists('cache_locks');
    }
};
