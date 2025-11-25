<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create the 'user_oauth_auth_codes' table to store authorization codes for users
        Schema::create('user_oauth_auth_codes', function (Blueprint $table) {
            $table->string('id', 100)->primary(); // Unique identifier for the auth code
            $table->char('user_id', 8)->index(); // User ID associated with the auth code
            $table->unsignedBigInteger('client_id'); // Client ID associated with the auth code
            $table->text('scopes')->nullable(); // Scopes associated with the auth code
            $table->boolean('revoked'); // Indicates if the auth code is revoked
            $table->dateTime('expires_at')->nullable(); // Expiration date of the auth code
        });

        // Create the 'user_oauth_access_tokens' table to store access tokens for users
        Schema::create('user_oauth_access_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary(); // Unique identifier for the access token
            $table->char('user_id', 8)->nullable()->index(); // User ID associated with the access token
            $table->unsignedBigInteger('client_id'); // Client ID associated with the access token
            $table->string('name')->nullable(); // Optional name for the access token
            $table->text('scopes')->nullable(); // Scopes associated with the access token
            $table->boolean('revoked'); // Indicates if the access token is revoked
            $table->timestamps(); // Timestamps for created_at and updated_at
            $table->dateTime('expires_at')->nullable(); // Expiration date of the access token
        });

        // Create the 'user_oauth_refresh_tokens' table to store refresh tokens for users
        Schema::create('user_oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('id', 100)->primary(); // Unique identifier for the refresh token
            $table->string('access_token_id', 100)->index(); // Access token ID associated with the refresh token
            $table->boolean('revoked'); // Indicates if the refresh token is revoked
            $table->dateTime('expires_at')->nullable(); // Expiration date of the refresh token
        });

        // Create the 'user_oauth_clients' table to store client information for users
        Schema::create('user_oauth_clients', function (Blueprint $table) {
            $table->bigIncrements('id'); // Unique identifier for the client
            $table->char('user_id', 8)->nullable()->index(); // User ID associated with the client
            $table->string('name'); // Name of the client
            $table->string('secret', 100)->nullable(); // Secret for the client
            $table->string('provider')->nullable(); // Provider associated with the client
            $table->text('redirect')->nullable(); // Redirect URL for the client
            $table->boolean('personal_access_client'); // Indicates if the client is a personal access client
            $table->boolean('password_client'); // Indicates if the client is a password grant client
            $table->boolean('revoked'); // Indicates if the client is revoked
            $table->timestamps(); // Timestamps for created_at and updated_at
        });

        // Create the 'user_oauth_personal_access_clients' table to store personal access client information
        Schema::create('user_oauth_personal_access_clients', function (Blueprint $table) {
            $table->bigIncrements('id'); // Unique identifier for the personal access client
            $table->unsignedBigInteger('client_id'); // Client ID associated with the personal access client
            $table->timestamps(); // Timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'user_oauth_auth_codes' table
        Schema::dropIfExists('user_oauth_auth_codes');

        // Drop the 'user_oauth_access_tokens' table
        Schema::dropIfExists('user_oauth_access_tokens');

        // Drop the 'user_oauth_refresh_tokens' table
        Schema::dropIfExists('user_oauth_refresh_tokens');

        // Drop the 'user_oauth_clients' table
        Schema::dropIfExists('user_oauth_clients');

        // Drop the 'user_oauth_personal_access_clients' table
        Schema::dropIfExists('user_oauth_personal_access_clients');
    }
};
