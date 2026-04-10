<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    // -----------------------------------------------------------------------
    // Public listing
    // -----------------------------------------------------------------------

    public function test_homepage_shows_published_posts(): void
    {
        $published = Post::factory()->published()->create();
        $draft     = Post::factory()->draft()->create();

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee($published->title);
        $response->assertDontSee($draft->title);
    }

    public function test_posts_can_be_searched(): void
    {
        $espresso = Post::factory()->published()->create(['title' => 'Guide de l espresso']);
        $other    = Post::factory()->published()->create(['title' => 'Origines du cafe']);

        $response = $this->get(route('posts.index', ['search' => 'espresso']));

        $response->assertOk();
        $response->assertSee($espresso->title);
        $response->assertDontSee($other->title);
    }

    public function test_posts_can_be_filtered_by_category(): void
    {
        $category = Category::factory()->create();
        $match    = Post::factory()->published()->create(['category_id' => $category->id]);
        $other    = Post::factory()->published()->create();

        $response = $this->get(route('posts.index', ['category' => $category->slug]));

        $response->assertOk();
        $response->assertSee($match->title);
        $response->assertDontSee($other->title);
    }

    // -----------------------------------------------------------------------
    // Single post
    // -----------------------------------------------------------------------

    public function test_published_post_is_accessible(): void
    {
        $post = Post::factory()->published()->create();

        $this->get(route('posts.show', $post->slug))->assertOk();
    }

    public function test_draft_post_returns_404(): void
    {
        $draft = Post::factory()->draft()->create();

        $this->get(route('posts.show', $draft->slug))->assertNotFound();
    }

    // -----------------------------------------------------------------------
    // Admin CRUD
    // -----------------------------------------------------------------------

    public function test_guest_cannot_access_admin(): void
    {
        $this->get(route('admin.posts.index'))->assertRedirect(route('login'));
    }

    public function test_admin_can_create_post(): void
    {
        $admin    = User::factory()->create(['is_admin' => true]);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post(route('admin.posts.store'), [
            'title'       => 'Mon premier article cafe',
            'body'        => '<p>Contenu de test.</p>',
            'category_id' => $category->id,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', ['title' => 'Mon premier article cafe']);
    }

    public function test_admin_can_delete_post(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $post  = Post::factory()->create(['user_id' => $admin->id]);

        $this->actingAs($admin)
             ->delete(route('admin.posts.destroy', $post))
             ->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
    }
}
