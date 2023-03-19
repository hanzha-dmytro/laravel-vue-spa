<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Post
 *
 * @property integer $id
 * @property boolean $author_id
 * @property boolean $category_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $content
 * @property string $image
 * @property boolean $is_visible
 * @property Carbon $published_at
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property \App\Models\Category $category
 * @mixin \Eloquent
 */

class Post extends Model
{
    use HasFactory, Filterable;

    const PAGINATION_LIMIT = 10;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'content',
        'image',
        'is_visible',
        'published_at',
    ];

    protected $dates = [
        'published_at',
        'updated_at',
        'created_at',
    ];

    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    public function category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
