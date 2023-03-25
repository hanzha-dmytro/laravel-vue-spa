<?php

namespace App\Models;

use App\Traits\Filterable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Page
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $content
 * @property boolean $is_visible
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @mixin \Eloquent
 */

class Page extends Model
{
    use HasFactory, Filterable;

    const PAGINATION_LIMIT = 12;

    protected $fillable = [
        'name',
        'slug',
        'content',
        'is_visible',
    ];
}
