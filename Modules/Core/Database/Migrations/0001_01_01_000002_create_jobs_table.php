<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to create the necessary job-related tables.
     */
    public function up(): void
    {
        // Create the 'jobs' table to store job information
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for the job
            $table->string('queue')->index(); // Name of the queue the job belongs to, indexed for performance
            $table->longText('payload'); // Serialized job data
            $table->unsignedTinyInteger('attempts'); // Number of attempts made to execute the job
            $table->unsignedInteger('reserved_at')->nullable(); // Timestamp when the job was reserved, can be null
            $table->unsignedInteger('available_at'); // Timestamp when the job becomes available for processing
            $table->unsignedInteger('created_at'); // Timestamp when the job was created
        });

        // Create the 'job_batches' table to manage batches of jobs
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // Unique identifier for the job batch
            $table->string('name'); // Name of the job batch
            $table->integer('total_jobs'); // Total number of jobs in the batch
            $table->integer('pending_jobs'); // Number of jobs that are still pending
            $table->integer('failed_jobs'); // Number of jobs that have failed
            $table->longText('failed_job_ids'); // IDs of the jobs that have failed
            $table->mediumText('options')->nullable(); // Additional options for the job batch, can be null
            $table->integer('cancelled_at')->nullable(); // Timestamp when the batch was cancelled, can be null
            $table->integer('created_at'); // Timestamp when the batch was created
            $table->integer('finished_at')->nullable(); // Timestamp when the batch was finished, can be null
        });

        // Create the 'failed_jobs' table to store information about failed jobs
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID for the failed job
            $table->string('uuid')->unique(); // Unique identifier for the failed job
            $table->text('connection'); // Connection used to process the job
            $table->text('queue'); // Queue from which the job was processed
            $table->longText('payload'); // Serialized job data that caused the failure
            $table->longText('exception'); // Exception message that was thrown during job processing
            $table->timestamp('failed_at')->useCurrent(); // Timestamp when the job failed, defaults to current time
        });
    }

    /**
     * Reverse the migrations to drop the job-related tables.
     */
    public function down(): void
    {
        // Drop the 'jobs' table if it exists
        Schema::dropIfExists('jobs');
        // Drop the 'job_batches' table if it exists
        Schema::dropIfExists('job_batches');
        // Drop the 'failed_jobs' table if it exists
        Schema::dropIfExists('failed_jobs');
    }
};
