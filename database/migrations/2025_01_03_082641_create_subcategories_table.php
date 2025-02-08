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
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id(); 
            $table->string('name')->nullable(); 
            $table->string('title')->nullable(); 
            $table->string('slug')->unique(); 
            $table->string('meta_title')->nullable(); 
            $table->text('description')->nullable(); 
            $table->text('meta_description')->nullable(); 
            $table->string('image')->nullable(); 
            $table->string('color')->nullable(); 
            $table->integer('sort_order')->default(0); 
            $table->unsignedBigInteger('category_id'); 
            $table->boolean('is_featured')->default(false); 
            $table->boolean('is_active')->default(true); 
            $table->timestamp('published_at')->nullable(); 
            $table->string('seo_keywords')->nullable(); 
            $table->enum('visibility', ['public', 'private', 'restricted'])->default('public'); 
            $table->integer('view_count')->default(0);
            $table->string('author')->nullable(); 
            $table->string('language')->default('en'); 
            $table->boolean('allow_comments')->default(true); 
            $table->json('additional_data')->nullable(); 
            $table->timestamps(); 
            $table->softDeletes(); 
            $table->foreign('category_id')
                ->references('id')->on('news_categories') 
                ->onDelete('cascade'); 
            $table->index('category_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subcategories');
    }
};
