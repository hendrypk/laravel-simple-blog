<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostsTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_post_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $respon = $this
            ->actingAs($user)
            ->get('/posts/create');

        $respon->assertOk();
    }

    
    public function test_store_post_creates_new_post_active(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $postData = [
            'title' => 'Test Post',
            'content' => 'This is a test post.',
            'user_id' => $user->id,
            'status' => Post::TYPE_ACTIVE,
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect(route('posts.show', Post::latest()->first()->id));
        $this->assertDatabaseHas('posts', $postData);
    }

    
    public function test_edit_post_page_loads_correctly(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user); 

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->get(route('posts.edit', $post->id));

        $response->assertOk();
        $response->assertSee($post->title);
        $response->assertSee($post->content);
    }

    
    public function test_update_post_changes_existing_post(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $post = Post::factory()->create();

        $updatedData = [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
            'published_at' => now(),
            'is_draft' => false, 
        ];

        $response = $this->post(route('posts.update', $post->id), $updatedData);
        $response->assertRedirect(route('posts.show', $post->id));
        $this->assertDatabaseHas('posts', [
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ]);
    }


    public function test_destroy_post_removes_post(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user); 

        $post = Post::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->delete(route('posts.destroy', $post->id));
        $response->assertRedirect(route('home'));
    }
}
