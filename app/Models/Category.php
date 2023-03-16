<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property boolean $is_visible
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property-read \App\Models\Post[] $posts
 * @mixin \Eloquent
 */

class Category extends Model
{
    use HasFactory, Filterable;

    const PAGINATION_LIMIT = 10;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_visible',
    ];

    public function posts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Post::class);
    }
}
