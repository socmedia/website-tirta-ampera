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
        // Create provinces table
        Schema::create('id_provinces', function (Blueprint $table) {
            $table->char('id', 2)->primary(); // Primary key for provinces
            $table->string('name'); // Name of the province
            $table->index('name'); // Index for the name column
        });

        // Create regencies table
        Schema::create('id_regencies', function (Blueprint $table) {
            $table->char('id', 4)->primary(); // Primary key for regencies
            $table->char('province_id', 2); // Foreign key referencing provinces
            $table->string('name'); // Name of the regency
            $table->foreign('province_id')->references('id')->on('id_provinces')->cascadeOnDelete(); // Foreign key constraint
            $table->index('name'); // Index for the name column
        });

        // Create districts table
        Schema::create('id_districts', function (Blueprint $table) {
            $table->char('id', 7)->primary(); // Primary key for districts
            $table->char('regency_id', 4); // Foreign key referencing regencies
            $table->string('name'); // Name of the district
            $table->foreign('regency_id')->references('id')->on('id_regencies')->cascadeOnDelete(); // Foreign key constraint
            $table->index('name'); // Index for the name column
        });

        // Create villages table
        Schema::create('id_villages', function (Blueprint $table) {
            $table->char('id', 10)->primary(); // Primary key for villages
            $table->char('district_id', 7); // Foreign key referencing districts
            $table->string('name'); // Name of the village
            $table->foreign('district_id')->references('id')->on('id_districts')->cascadeOnDelete(); // Foreign key constraint
            $table->index('name'); // Index for the name column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop villages table first due to foreign key constraints
        Schema::dropIfExists('id_villages');
        // Drop districts table
        Schema::dropIfExists('id_districts');
        // Drop regencies table
        Schema::dropIfExists('id_regencies');
        // Drop provinces table
        Schema::dropIfExists('id_provinces');
    }
};
