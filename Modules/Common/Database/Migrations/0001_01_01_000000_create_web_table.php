<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
// Perhatikan: 'use Modules\Common\Enums\InputType;' tidak digunakan di sini,
// jadi saya hapus. Jika Anda membutuhkannya, tambahkan kembali.

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Tetap sama, sudah tidak translatable
        Schema::create('app_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group');
            $table->string('key')->unique();
            $table->string('type')->default('input:text');
            $table->json('meta')->nullable();
            $table->string('name')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Create categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // Kolom dari category_translations
            $table->string('name');
            $table->string('slug');
            $table->longText('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('icon')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('featured')->default(0)->comment('0 for not featured & 1 for featured');
            $table->string('group')->nullable();
            $table->char('created_by', 8)->nullable();
            $table->char('updated_by', 8)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');

            // Ensure uniqueness of (group, slug) only if group is not null
            $table->unique(['group', 'slug']);
        });

        // Create sliders table
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            // Kolom dari slider_translations
            $table->string('heading')->nullable();
            $table->string('sub_heading')->nullable();
            $table->longText('description')->nullable();
            $table->string('alt')->nullable();

            // Kolom asli
            $table->string('type')->index();
            $table->string('desktop_media_path')->nullable();
            $table->string('mobile_media_path')->nullable();
            $table->unsignedBigInteger('sort_order')->default(0);
            $table->boolean('status')->default(1);
            $table->json('meta')->nullable();
            $table->char('created_by', 8)->nullable();
            $table->char('updated_by', 8)->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
        });

        // Create contents table
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            // Kolom dari content_translations
            $table->string('name')->nullable();
            $table->text('value')->nullable();
            $table->string('page');
            $table->string('section')->nullable();
            $table->string('key')->unique();
            $table->string('type')->default('content');
            $table->string('input_type')->default('input:text');
            $table->json('meta')->nullable();
            $table->timestamps();
        });

        // Create posts table
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('subject')->nullable();
            $table->longText('content')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('type')->default('blog')->nullable();
            $table->string('thumbnail');
            $table->text('tags')->nullable();
            $table->string('reading_time')->nullable();
            $table->bigInteger('number_of_views')->default(0);
            $table->bigInteger('number_of_shares')->default(0);
            $table->char('author', 8)->nullable();
            $table->char('published_by', 8)->nullable();
            $table->dateTime('published_at')->nullable();
            $table->dateTime('archived_at')->default(null)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
            $table->foreign('author')->references('id')->on('users')->nullOnDelete();
        });

        // Create faqs table
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('slug')->nullable()->unique();
            $table->text('answer')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('sort_order')->nullable();
            $table->boolean('featured')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories')->nullOnDelete();
        });

        // Tetap sama, tidak translatable
        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('whatsapp_code')->default('id');
            $table->unsignedBigInteger('whatsapp_number');
            $table->string('topic')->nullable();
            $table->string('subject');
            $table->text('message');
            $table->dateTime('seen_at')->nullable();
            $table->char('seen_by', 8)->nullable();
            $table->timestamps();

            $table->foreign('seen_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop tables dalam urutan terbalik (tanpa tabel translation)
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('faqs');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('contents');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('app_settings');
    }
};
