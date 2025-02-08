<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\NewsCategory;

class CategoryControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_category()
    {
        $response = $this->postJson('/api/admin/create-category', [
            'name' => 'Technology',
    'title' => 'Latest Technology News',
    'slug' => 'latest-technology-news',
    'meta_title' => 'Technology News - Stay Updated',
    'description' => 'This category covers the latest trends, updates, and insights in technology from around the world.',
    'meta_description' => 'Get the latest updates and news in the world of technology. Explore trends, gadgets, AI, and more.',
    'image' => 'example_image.jpg', // Upload an image file to test
    'icon' => 'example_icon.png', // Upload an icon file to test
    'color' => '#ff5733', // Example color code
    'sort_order' => 1, // Order for display purposes
    'parent_id' => null, // Assuming it’s a root category; replace with a valid `id` for subcategories
    'is_featured' => true, // This category is featured
    'is_active' => true, // Category is active
    'seo_keywords' => 'technology, gadgets, AI, innovation', // Keywords for SEO purposes
    'visibility' => 'public', // This category is visible to everyone
    'author' => 'John Doe', // Author of the category or content
    'language' => 'en', // Language code
    'allow_comments' => 'sdsd', // Allow users to comment on posts in this category
    'additional_data' => json_encode(['extra_info' => 'Special features included', 'related_topics' => ['AI', 'VR']]), // Example JSON data
        ]);

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'Category created successfully'
                 ]);
    }
}
