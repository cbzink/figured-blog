<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Post;
use App\Author;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {

    $author = factory(Author::class)->create();

    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'author' => [
            'id' => $author->id,
            'name' => $author->name,
        ],
        'tags' => $faker->words(3),
    ];
});
