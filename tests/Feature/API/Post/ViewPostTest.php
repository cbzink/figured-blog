<?php

namespace Tests\Feature\API\Post;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewPostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function viewing_all_posts()
    {
        $this->withoutExceptionHandling();

        $posts = factory(Post::class, 3)->create();

        $response = $this->json('GET', 'api/post');

        $response->assertStatus(200);
        $response->assertJson(['data' => [
            [
                'id' => $posts[2]->id,
                'title' => $posts[2]->title,
                'body' => $posts[2]->body,
                'author' => $posts[2]->author,
                'tags' => $posts[2]->tags,
                'created_at' => $posts[2]->created_at->toIso8601String(),
            ],
            [
                'id' => $posts[1]->id,
                'title' => $posts[1]->title,
                'body' => $posts[1]->body,
                'author' => $posts[1]->author,
                'tags' => $posts[1]->tags,
                'created_at' => $posts[1]->created_at->toIso8601String(),
            ],
            [
                'id' => $posts[0]->id,
                'title' => $posts[0]->title,
                'body' => $posts[0]->body,
                'author' => $posts[0]->author,
                'tags' => $posts[0]->tags,
                'created_at' => $posts[0]->created_at->toIso8601String(),
            ],
        ]]);
    }

    /** @test */
    public function viewing_a_single_post()
    {
        $this->withoutExceptionHandling();

        $post = factory(Post::class)->create();

        $response = $this->json('GET', "api/post/{$post->id}");

        $response->assertStatus(200);
        $response->assertJson(['data' => [
            'id' => $post->id,
            'title' => $post->title,
            'body' => $post->body,
            'author' => $post->author,
            'tags' => $post->tags,
            'created_at' => $post->created_at->toIso8601String(),
        ]]);
    }

    /** @test */
    public function viewing_a_non_existent_post_returns_a_404_error()
    {
        $response = $this->json('GET', 'api/post/999');

        $response->assertStatus(404);
    }
}
