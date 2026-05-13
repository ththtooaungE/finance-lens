<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'name', 'description'])]
class Collection extends Model
{
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_collection')->withTimestamps();
        
    }
    public function costs(): HasMany
    {
        return $this->hasMany(Cost::class);
    }
}
