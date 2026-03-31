<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class WalletTransaction extends Model
{
    use HasCustomId;

    protected $fillable = ['user_id', 'amount', 'type', 'description'];

    public function getTablePrefix()
    {
        return 'WAL';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
