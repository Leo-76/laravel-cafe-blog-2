<?php

namespace Tests\Unit;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_reading_time_is_calculated_correctly(): void
    {
        $words = str_repeat('mot ', 400); // 400 words = ~2 minutes
        $post  = Post::factory()->make(['body' => $words]);

        $this->assertEquals(2, $post->readingTime());
    }

    public function test_slug_is_generated_from_title_on_create(): void
    {
        $post = Post::factory()->create(['title' => 'Guide du cafe filtre', 'slug' => '']);

        $this->assertNotEmpty($post->slug);
        $this->assertStringContainsString('guide', $post->slug);
    }

    public function test_is_published_returns_false_for_draft(): void
    {
        $draft = Post::factory()->draft()->make();

        $this->assertFalse($draft->isPublished());
    }

    public function test_is_published_returns_true_when_published_at_is_past(): void
    {
        $post = Post::factory()->published()->make();

        $this->assertTrue($post->isPublished());
    }
}
