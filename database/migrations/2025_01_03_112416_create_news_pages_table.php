<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('news_pages', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable();
            $table->string('heading')->nullable();
            $table->json('sections')->nullable(); 
            $table->string('title'); 
            $table->string('slug')->nullable(); 
            $table->text('content')->nullable(); 
            $table->text('excerpt')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable(); 
            $table->string('meta_keywords')->nullable(); 
            $table->string('canonical_url')->nullable(); 
            $table->string('template')->default('default'); 
            $table->boolean('is_active')->default(true); 
            $table->boolean('is_featured')->default(false); 
            $table->boolean('is_trending')->default(false); 
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_premium')->default(false); 
            $table->boolean('is_verified')->default(false); 
            $table->string('status')->default('draft'); 
            $table->enum('visibility', ['public', 'private', 'restricted'])->default('public');
            $table->unsignedBigInteger('category_id')->nullable(); 
            $table->unsignedBigInteger('subcategory_id')->nullable(); 
            $table->unsignedBigInteger('author_id')->nullable(); 
            $table->unsignedBigInteger('editor_id')->nullable(); 
            $table->unsignedBigInteger('parent_id')->nullable(); 
            $table->string('language')->default('en'); 
            $table->integer('view_count')->default(0); 
            $table->integer('like_count')->default(0); 
            $table->integer('share_count')->default(0); 
            $table->integer('comment_count')->default(0); 
            $table->json('tags')->nullable(); 
            $table->json('related_articles')->nullable(); 
            $table->json('analytics')->nullable(); 
            $table->json('additional_data')->nullable(); 
            $table->json('custom_fields')->nullable(); 
            $table->json('seo_settings')->nullable(); 

            $table->string('thumbnail')->nullable(); 
            $table->string('banner_image')->nullable(); 
            $table->json('image_gallery')->nullable(); 
            $table->string('video_embed')->nullable(); 
            $table->json('video_gallery')->nullable(); 
            $table->string('audio_embed')->nullable(); 
            $table->string('icon')->nullable(); 
            $table->string('icon_class')->nullable(); // Icon CSS Class
            $table->string('icon_color')->nullable(); // Icon Color Code
            $table->text('author_notes')->nullable(); 
            $table->boolean('allow_comments')->default(true);
            $table->integer('sort_order')->default(0);
            $table->string('source')->nullable();
            $table->string('sponsor')->nullable();
            $table->boolean('monetization_enabled')->default(false); // Enable Ads/Monetization
            $table->string('ad_placement')->nullable();
            $table->boolean('push_notifications')->default(false);
            $table->string('geolocation')->nullable();
            $table->string('device_target')->nullable(); // Mobile, Desktop, Tablet

            // Timestamps
            $table->timestamp('published_at')->nullable(); // Publish Date
            $table->timestamp('scheduled_at')->nullable(); // Scheduled Publish Date
            $table->timestamp('last_reviewed_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('news_categories')->onDelete('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('parent_id')->references('id')->on('news_pages')->onDelete('set null');
            $table->index(
                ['category_id', 'subcategory_id', 'status', 'is_active', 'is_trending'],
                'news_pages_idx'
            );        
        });
    }

    public function down()
    {
        Schema::dropIfExists('news_pages');
    }
};
