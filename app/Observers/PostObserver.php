<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;

class PostObserver
{
    /**
     * Handle the Post "created" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function created(Post $post)
    {
        Post::when($post->is_pinned, function (Builder $query) use ($post) {
            $query->where('id', '<>', $post->id)->update(['is_pinned' => 0]);
        });
    }

    /**
     * Handle the Post "updated" event.
     *
     * @param  \App\Models\Post  $post
     * @return void
     */
    public function updated(Post $post)
    {
        Post::when($post->is_pinned, function (Builder $query) use ($post) {
            $query->where('id', '<>', $post->id)->update(['is_pinned' => 0]);
        });
    }
}
