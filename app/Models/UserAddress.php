<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use \App\Traits\HasCustomId;

    protected $fillable = [
        'user_id', 'name', 'mobile', 'alt_mobile', 'address_line', 'landmark', 'city', 'state', 'pincode', 'type', 'is_default'
    ];

    public function getTablePrefix()
    {
        return 'ADR';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
