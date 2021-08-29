<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\HasPermissions;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @mixin \Eloquent
 */

class Role extends Model
{
    use HasFactory, HasPermissions, Filterable;

    const PAGINATION_LIMIT = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public static function getRoleBySlug(string $slug): mixed
    {
        return self::where('slug', $slug)->first();
    }
}
