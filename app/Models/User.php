<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use App\Traits\Filterable;
use App\Traits\HasPermissions;
use Carbon\Carbon;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\User
 *
 * @property integer $id
 * @property integer $role_id
 * @property string $name
 * @property string $email
 * @property string $description
 * @property string $avatar
 * @property string $password
 * @property string $remember_token
 * @property boolean $is_active
 * @property Carbon $updated_at
 * @property Carbon $created_at
 * @property \App\Models\Role $role
 * @mixin \Eloquent
 */

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, HasPermissions, Filterable;

    const PAGINATION_LIMIT = 12;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'password',
        'avatar',
        'description',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * @param $token
     * @return void
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify( new ResetPasswordNotification($token));
    }
}
