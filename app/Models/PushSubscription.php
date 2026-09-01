<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class PushSubscription extends Model
{
    use HasCustomId;

    public function getTablePrefix()
    {
        return 'SUB';
    }

    protected $fillable = [
        'user_id',
        'endpoint',
        'public_key',
        'auth_token',
        'content_encoding',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
