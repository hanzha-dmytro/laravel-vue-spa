<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Comment
 *
 * @property integer $id
 * @property integer $post_id
 * @property string $name
 * @property string $content
 * @property boolean $is_visible
 * @property Carbon $published_at
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property \App\Models\Post $post
 * @mixin \Eloquent
 */

class Comment extends Model
{
    use HasFactory, Filterable;

    const PAGINATION_LIMIT = 30;

    protected $fillable = [
        'post_id',
        'name',
        'content',
        'is_visible',
        'published_at',
    ];

    protected $dates = [
        'published_at',
        'updated_at',
        'created_at',
    ];

    public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
