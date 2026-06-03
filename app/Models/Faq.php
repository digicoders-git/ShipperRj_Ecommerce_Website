<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasCustomId;

class Faq extends Model
{
    use HasCustomId;

    protected $fillable = ['question', 'answer', 'status', 'sort_order'];
}
