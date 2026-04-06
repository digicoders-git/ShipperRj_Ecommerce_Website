<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SubAdmin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'password',
        'plain_password',
        'permissions',
        'status',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permissions' => 'array',
        'last_login_at' => 'datetime',
        'status' => 'boolean',
    ];

    /**
     * Check if sub-admin has a specific permission
     */
    public function hasPermission($permission): bool
    {
        if (!$this->status)
            return false;

        $permissions = $this->permissions ?? [];
        return in_array($permission, $permissions);
    }
}
