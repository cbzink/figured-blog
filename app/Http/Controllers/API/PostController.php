<?php

namespace App\Http\Controllers\API;

use App\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreUpdatePostRequest;

class PostController extends Controller
{
    /**
     * Returns a list of all posts.
     *
     * @return App\Http\Resources\PostResource
     */
    public function index()
    {
        return PostResource::collection(Post::all());
    }

    /**
     * Returns a given post.
     *
     * @param  App\Post   $post
     * @return App\Http\Resources\PostResource
     */
    public function show(Post $post)
    {
        return new PostResource($post);
    }

    /**
     * Stores a new post.
     *
     * @param  App\Http\Requests\StoreUpdatePostRequest $request
     * @return App\Http\Resources\PostResource
     */
    public function store(StoreUpdatePostRequest $request)
    {
        $author = Auth::user();

        $post = Post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'author' => [
                'id' => $author->id,
                'name' => $author->name,
            ],
            'tags' => $request->input('tags'),
        ]);

        return new PostResource($post);
    }

    /**
     * Updates an existing post.
     *
     * @param  App\Post $post
     * @param  App\Http\Requests\StoreUpdatePostRequest $request
     * @return App\Http\Resources\PostResource
     */
    public function update(Post $post, StoreUpdatePostRequest $request)
    {
        $post->update($request->only('title', 'body', 'tags'));

        return new PostResource($post);
    }

    /**
     * Deletes an existing post.
     *
     * @param  App\Post   $post
     * @return Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return response(null, 204);
    }
}
