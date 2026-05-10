<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'name', 'color', 'is_active'])]
class Category extends Model
{
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
