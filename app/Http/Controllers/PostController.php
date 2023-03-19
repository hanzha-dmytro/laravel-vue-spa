<?php

namespace App\Http\Controllers;

use App\Http\Filters\PostFilter;
use App\Http\Requests\PostIndexRequest;
use App\Http\Requests\PostSaveRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(PostIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PostResource::collection(
            Post::filter(new PostFilter($request))->with(['category', 'comments'])->paginate(Post::PAGINATION_LIMIT)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostSaveRequest $request
     * @return PostResource
     */
    public function store(PostSaveRequest $request): PostResource
    {
        $post = new Post($request->validated());

        // Set post author
        $post->user_id = $request->user()?->id;

        if($request->hasFile('image')) {
            $post->image = $request->image->store('images/post', 'public');
        }

        $post->save();
        return new PostResource($post->load(['category']));
    }

    /**
     * Display the specified resource.
     *
     * @param Post $post
     * @return PostResource
     */
    public function show(Post $post): PostResource
    {
        return new PostResource($post->load(['category']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostSaveRequest $request
     * @param Post $post
     * @return PostResource
     */
    public function update(PostSaveRequest $request, Post $post): PostResource
    {
        $post->fill($request->validated());

        if($request->hasFile('image')) {
            $post->image = $request->image->store('images/post', 'public');
        }

        $post->save();
        return new PostResource($post->load(['category']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return bool|null
     */

    public function destroy(Post $post): ?bool
    {
        return $post->delete();
    }

    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return PostResource::collection(Post::all());
    }
}
