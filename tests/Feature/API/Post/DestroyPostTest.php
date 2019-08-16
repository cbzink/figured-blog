<?php

namespace Tests\Feature\API\Post;

use App\Post;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DestroyPostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var App\Post
     */
    private $post;

    /**
     * @var App\Author
     */
    private $author;

    public function setUp(): void
    {
        parent::setUp();

        $this->post = factory(Post::class)->create();
        $this->author = Author::first();
    }

    /** @test */
    public function destroying_a_post()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->author, 'api')->json('DELETE', "api/post/{$this->post->id}");

        $response->assertStatus(204);

        $this->assertEquals(0, Post::all()->count());
    }

    /** @test */
    public function guests_can_not_destroy_posts()
    {
        $response = $this->json('DELETE', "api/post/{$this->post->id}");

        $response->assertStatus(401);
    }
}
