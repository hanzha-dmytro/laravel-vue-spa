<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Role
 *
 * @property integer $id
 * @property string $slug
 * @property-read Model|\Eloquent $permissible
 * @mixin \Eloquent
 */

class Permission extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Get the parent permissible model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function permissible(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }
}
