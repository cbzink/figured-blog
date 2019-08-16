<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class PostTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function posts_are_ordered_in_reverse_chronological_order()
    {
        $postA = factory(Post::class)->create();
        $postB = factory(Post::class)->create();

        $posts = Post::all();

        $this->assertTrue($posts[0]->is($postB));
        $this->assertTrue($posts[1]->is($postA));
    }
}
