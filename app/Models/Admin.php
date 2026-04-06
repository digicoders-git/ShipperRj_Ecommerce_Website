<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Traits\HasCustomId;

class Admin extends Authenticatable
{
    use Notifiable, HasCustomId;

    public function getTablePrefix()
    {
        return 'ADMN';
    }


    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'plain_password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
