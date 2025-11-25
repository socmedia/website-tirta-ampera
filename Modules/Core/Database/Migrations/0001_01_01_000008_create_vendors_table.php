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
        // Create the 'vendors' table with the specified columns and constraints
        Schema::create('vendors', function (Blueprint $table) {
            $table->char('id', 8)->primary(); // Unique identifier for the vendor
            $table->string('name')->nullable(); // Vendor's name, can be null
            $table->string('avatar')->nullable(); // URL to the vendor's avatar, can be null
            $table->string('email')->unique(); // Vendor's email, must be unique
            $table->tinyInteger('is_seen')->default(0); // Indicates if the vendor has been seen, default is 0 (false)
            $table->enum('status', ['active', 'inactive', 'disable'])->default('active'); // Vendor's status with default as 'active'
            $table->timestamp('email_verified_at')->nullable(); // Timestamp for when the email was verified, can be null
            $table->string('password'); // Vendor's password
            $table->text('two_factor_secret')->nullable(); // Column to store the vendor's two-factor authentication secret, can be null
            $table->text('two_factor_recovery_codes')->nullable(); // Column to store the vendor's two-factor recovery codes, can be null
            $table->timestamp('two_factor_confirmed_at')->nullable(); // Timestamp to indicate when the two-factor authentication was confirmed, can be null
            $table->rememberToken(); // Token for "remember me" functionality
            $table->char('created_by', 8)->nullable(); // ID of the vendor who created this record, can be null
            $table->char('updated_by', 8)->nullable(); // ID of the vendor who last updated this record, can be null
            $table->softDeletes(); // Enables soft deletes for the vendor
            $table->timestamps(); // Automatically manages created_at and updated_at timestamps
        });

        // Create foreign key constraints for created_by and updated_by fields
        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('created_by')->references('id')->on('vendors'); // Foreign key reference for created_by
            $table->foreign('updated_by')->references('id')->on('vendors'); // Foreign key reference for updated_by
        });

        // Create the 'vendor_password_reset_tokens' table to store password reset tokens
        Schema::create('vendor_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Email address associated with the token, serves as the primary key
            $table->string('token'); // The password reset token
            $table->timestamp('created_at')->nullable(); // Timestamp for when the token was created, can be null
        });

        // Create the 'vendor_profiles' table to store vendor profile information
        Schema::create('vendor_profiles', function (Blueprint $table) {
            $table->char('vendor_id', 8)->primary(); // Unique identifier for the vendor, serves as the primary key
            $table->string('company_name')->nullable(); // Vendor's company name, can be null
            $table->date('date_of_birth')->nullable(); // Vendor's date of birth, can be null
            $table->string('about')->nullable(); // Brief description about the vendor, can be null
            $table->char('province_id', 2)->nullable(); // ID of the province, can be null
            $table->char('regency_id', 4)->nullable(); // ID of the regency, can be null
            $table->char('district_id', 7)->nullable(); // ID of the district, can be null
            $table->char('village_id', 10)->nullable(); // ID of the village, can be null
            $table->string('address')->nullable(); // Vendor's address, can be null
            $table->string('postal_code')->nullable(); // Postal code for the vendor's address, can be null
            $table->enum('gender', ['Pria', 'Wanita'])->nullable(); // Vendor's gender, can be 'Pria' (Male) or 'Wanita' (Female), can be null
            $table->char('phone_code', 3)->default('id')->nullable(); // Country code for the phone number, default is 'id' (Indonesia), can be null
            $table->char('phone_number', 20)->nullable(); // Vendor's phone number, can be null
            $table->char('whatsapp_code', 3)->default('id')->nullable(); // Country code for the WhatsApp number, default is 'id' (Indonesia), can be null
            $table->char('whatsapp_number', 20)->nullable(); // Vendor's WhatsApp number, can be null
            $table->json('social_medias')->nullable(); // JSON field to store social media links, can be null
            $table->string('website')->nullable(); // Vendor's website URL, can be null
            $table->timestamps(); // Automatically manages created_at and updated_at timestamps
            $table->foreign('vendor_id')->references('id')->on('vendors'); // Foreign key reference to vendors
        });

        // Create the 'vendor_activity_logs' table to track vendor activities
        Schema::create('vendor_activity_logs', function (Blueprint $table) {
            $table->id(); // Unique identifier for the activity log
            $table->char('vendor_id', 8); // Foreign key reference to the vendor
            $table->text('activity'); // Description of the activity
            $table->timestamps(); // Automatically manages created_at and updated_at timestamps
            $table->foreign('vendor_id')->references('id')->on('vendors'); // Foreign key reference to vendors
        });

        // Create the 'vendor_settings' table to store vendor-specific settings
        Schema::create('vendor_settings', function (Blueprint $table) {
            $table->id(); // Unique identifier for the settings
            $table->char('vendor_id', 8); // Foreign key reference to the vendor
            $table->string('setting_key'); // Key for the setting
            $table->text('setting_value')->nullable(); // Value for the setting, can be null
            $table->string('type')->default('string'); // Type of the setting
            $table->timestamps(); // Automatically manages created_at and updated_at timestamps
            $table->foreign('vendor_id')->references('id')->on('vendors'); // Foreign key reference to vendors
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the 'vendor_password_reset_tokens' table
        Schema::dropIfExists('vendor_password_reset_tokens');

        // Drop foreign key constraints for created_by and updated_by fields
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['created_by']); // Drop foreign key reference for created_by
            $table->dropForeign(['updated_by']); // Drop foreign key reference for updated_by
        });

        // Drop the 'vendor_activity_logs' table
        Schema::dropIfExists('vendor_activity_logs');

        // Drop the 'vendor_profiles' table
        Schema::dropIfExists('vendor_profiles');

        // Drop the 'vendor_settings' table
        Schema::dropIfExists('vendor_settings');

        // Drop the 'vendors' table
        Schema::dropIfExists('vendors');
    }
};
