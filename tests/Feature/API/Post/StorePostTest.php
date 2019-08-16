<?php

namespace Tests\Feature\API\Post;

use App\Post;
use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class StorePostTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var App\Author
     */
    private $author;

    public function setUp(): void
    {
        parent::setUp();

        $this->author = factory(Author::class)->create();
    }

    private function validParams($overrides = [])
    {
        return array_merge([
            'title' => 'Test Title',
            'body' => 'Test Body',
            'tags' => ['test', 'phpunit'],
        ], $overrides);
    }

    private function assertValidationError($field)
    {
        $this->response->assertJsonValidationErrors($field);
        $this->assertEquals(0, Post::all()->count());
    }

    /** @test */
    public function storing_a_post()
    {
        $this->withoutExceptionHandling();

        $response = $this->actingAs($this->author, 'api')->json('POST', 'api/post', [
            'title' => 'My test post.',
            'body' => 'This is a story about a test case.',
            'tags' => ['testing', 'phpunit'],
        ]);

        tap(Post::first(), function ($post) use ($response) {
            $response->assertStatus(201);
            $response->assertJson(['data' => [
                'title' => 'My test post.',
                'body' => 'This is a story about a test case.',
                'author' => [
                    'id' => $this->author->id,
                    'name' => $this->author->name,
                ],
                'tags' => ['testing', 'phpunit'],
            ]]);

            $this->assertEquals('My test post.', $post->title);
            $this->assertEquals('This is a story about a test case.', $post->body);
            $this->assertEquals($this->author->id, $post->author['id']);
            $this->assertEquals($this->author->name, $post->author['name']);
            $this->assertEquals(['testing', 'phpunit'], $post->tags);
        });
    }

    /** @test */
    public function guests_can_not_store_posts()
    {
        $this->response = $this->json('POST', 'api/post', $this->validParams());

        $this->response->assertStatus(401);
    }

    /** @test */
    public function title_is_required()
    {
        $this->response = $this->actingAs($this->author, 'api')->json('POST', 'api/post', $this->validParams(['title' => '']));

        $this->response->assertStatus(422);
        $this->assertValidationError('title');
    }

    /** @test */
    public function body_is_required()
    {
        $this->response = $this->actingAs($this->author, 'api')->json('POST', 'api/post', $this->validParams(['body' => '']));

        $this->response->assertStatus(422);
        $this->assertValidationError('body');
    }

    /** @test */
    public function tags_is_required()
    {
        $this->response = $this->actingAs($this->author, 'api')->json('POST', 'api/post', $this->validParams(['tags' => '']));

        $this->response->assertStatus(422);
        $this->assertValidationError('tags');
    }

    /** @test */
    public function tags_must_be_an_array()
    {
        $this->response = $this->actingAs($this->author, 'api')->json('POST', 'api/post', $this->validParams(['tags' => 'not-an-array']));

        $this->response->assertStatus(422);
        $this->assertValidationError('tags');
    }
}
