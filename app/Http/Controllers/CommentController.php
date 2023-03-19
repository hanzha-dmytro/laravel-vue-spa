<?php

namespace App\Http\Controllers;

use App\Http\Filters\CommentFilter;
use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\CommentSaveRequest;
use App\Http\Requests\CommentStatusRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param CommentIndexRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(CommentIndexRequest $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CommentResource::collection(
            Comment::filter(new CommentFilter($request))->with('post')->paginate(Comment::PAGINATION_LIMIT)
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CommentSaveRequest $request
     * @return CommentResource
     */
    public function store(CommentSaveRequest $request): CommentResource
    {
        $comment = Comment::create($request->validated());
        return new CommentResource($comment->load('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CommentSaveRequest $request
     * @param Comment $comment
     * @return CommentResource
     */
    public function update(CommentSaveRequest $request, Comment $comment): CommentResource
    {
        $comment->update($request->validated());
        return new CommentResource($comment->load('post'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Comment $comment
     * @return bool|null
     */
    public function destroy(Comment $comment): ?bool
    {
        return $comment->delete();
    }

    /**
     * Display all items of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return CommentResource::collection(Comment::all());
    }

    /**
     * Change status for the specified resource from storage.
     *
     * @param CommentStatusRequest $request
     * @param Comment $comment
     * @return CommentResource
     */
    public function changeStatus(CommentStatusRequest $request, Comment $comment): CommentResource
    {
        $comment->is_visible = $request->get('is_visible');
        $comment->save();
        return new CommentResource($comment->load('post'));
    }
}
