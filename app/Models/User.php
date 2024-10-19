<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RolePermission[] $rolePermissions
 * @method mixed hasPermission(string|array $slug)
 * @method static \Illuminate\Database\Eloquent\Builder|User hasAnyPermission(string|array $permission)
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function permissions()
    {
        return $this->hasManyThrough(
            Permission::class,
            RolePermission::class,
            'id',
            'role_id'
        );
    }

    function hasRole($role)
    {
        return $this->role->contains('code', $role);
    }

    function hasPermission(string|array $slug): bool
    {
        $slug = is_array($slug) ? $slug : [$slug];
        return static::whereKey($this->id)->hasAnyPermission($slug)->exists();
    }

    public function scopeHasAnyPermission($query, string|array $permission)
    {
info($this->role->permissions);
        $query->whereHas('role.permissions', function ($query) use ($permission) {
            $query->where(function ($query) use ($permission) {
                collect($permission)->each(function ($permission) use ($query) {
                    $query->orWhere(DB::raw('lower(slug)'), 'like', strtolower($permission));
                });
            });
        });
    }
}
