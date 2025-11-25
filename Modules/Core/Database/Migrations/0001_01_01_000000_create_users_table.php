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
        // Create the 'users' table with the specified columns and constraints
        Schema::create('users', function (Blueprint $table) {
            $table->char('id', 8)->primary(); // Unique identifier for the user
            $table->string('name')->nullable(); // User's name, can be null
            $table->string('avatar')->nullable(); // URL to the user's avatar, can be null
            $table->string('email')->unique(); // User's email, must be unique
            $table->tinyInteger('is_seen')->default(0); // Indicates if the user has been seen, default is 0 (false)
            $table->enum('status', ['active', 'inactive', 'disable'])->default('active'); // User's status with default as 'active'
            $table->timestamp('email_verified_at')->nullable(); // Timestamp for when the email was verified, can be null
            $table->string('password'); // User's password
            $table->text('two_factor_secret')->nullable(); // Column to store the user's two-factor authentication secret, can be null
            $table->text('two_factor_recovery_codes')->nullable(); // Column to store the user's two-factor recovery codes, can be null
            $table->timestamp('two_factor_confirmed_at')->nullable(); // Timestamp to indicate when the two-factor authentication was confirmed, can be null
            $table->rememberToken(); // Token for "remember me" functionality
            $table->char('created_by', 8)->nullable(); // ID of the user who created this record, can be null
            $table->char('updated_by', 8)->nullable(); // ID of the user who last updated this record, can be null
            $table->softDeletes(); // Enables soft deletes for the user
            $table->timestamps(); // Automatically manages created_at and updated_at timestamps
        });

        // Create foreign key constraints for created_by and updated_by fields
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('users'); // Foreign key reference for created_by
            $table->foreign('updated_by')->references('id')->on('users'); // Foreign key reference for updated_by
        });

        // Create the 'user_password_reset_tokens' table to store password reset tokens
        Schema::create('user_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email address associated with the token, serves as the primary key
            $table->string('token'); // The password reset token
            $table->timestamp('created_at')->nullable(); // Timestamp for when the token was created, can be null
        });

        // Create the 'sessions' table to manage user sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // Unique identifier for the session, serves as the primary key
            $table->char('user_id', 8)->nullable()->index(); // Foreign key reference to the user, can be null
            $table->string('ip_address', 45)->nullable(); // IP address of the user, can be null
            $table->text('user_agent')->nullable(); // User agent string, can be null
            $table->longText('payload'); // Session payload data
            $table->integer('last_activity')->index(); // Timestamp of the last activity, indexed for performance
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'user_sessions' table
        Schema::dropIfExists('user_sessions');

        // Drop the 'user_password_reset_tokens' table
        Schema::dropIfExists('user_password_reset_tokens');

        // Drop foreign key constraints for created_by and updated_by fields
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']); // Drop foreign key reference for created_by
            $table->dropForeign(['updated_by']); // Drop foreign key reference for updated_by
        });

        // Drop the 'users' table
        Schema::dropIfExists('users');
    }
};
