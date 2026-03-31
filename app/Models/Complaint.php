<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Complaint extends Model
{
    use HasCustomId;

    protected $fillable = ['user_id', 'product_id', 'subject', 'message', 'status', 'admin_comment'];

    public function getTablePrefix()
    {
        return 'COMP';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
