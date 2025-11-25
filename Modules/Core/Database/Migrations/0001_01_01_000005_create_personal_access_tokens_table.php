<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to create the personal_access_tokens table.
     *
     * @return void
     */
    public function up(): void
    {
        // Create the 'personal_access_tokens' table to store personal access tokens
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->bigIncrements('id'); // Auto-incrementing ID for the token
            $table->morphs('tokenable'); // Polymorphic relation for the entity that owns the token
            $table->string('name'); // Name of the token
            $table->string('token', 64)->unique(); // Unique token string
            $table->text('abilities')->nullable(); // Abilities associated with the token, can be null
            $table->timestamp('last_used_at')->nullable(); // Timestamp for when the token was last used, can be null
            $table->timestamps(); // Automatically manage created_at and updated_at timestamps
        });
    }

    /**
     * Reverse the migrations to drop the personal_access_tokens table.
     *
     * @return void
     */
    public function down(): void
    {
        // Drop the 'personal_access_tokens' table if it exists
        Schema::dropIfExists('personal_access_tokens');
    }
};
