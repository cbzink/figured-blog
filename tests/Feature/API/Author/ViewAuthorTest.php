<?php

namespace Tests\Feature\API\Author;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ViewAuthorTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function viewing_me()
    {
        $this->withoutExceptionHandling();

        $author = factory(Author::class)->create();

        $response = $this->actingAs($author, 'api')->json('GET', 'api/author/me');

        $response->assertSuccessful();
        $response->assertJson([
            'data' => [
                'id' => $author->id,
                'name' => $author->name,
                'email' => $author->email,
            ],
        ]);
    }

    /** @test */
    public function guests_can_not_view_me()
    {
        $response = $this->json('GET', 'api/author/me');

        $response->assertStatus(401);
    }
}
