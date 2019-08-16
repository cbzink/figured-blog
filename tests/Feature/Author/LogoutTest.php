<?php

namespace Tests\Feature\Author;

use App\Author;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LogoutTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function successfully_logging_out()
    {
        $author = factory(Author::class)->create();

        $response = $this->actingAs($author)->get('logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
