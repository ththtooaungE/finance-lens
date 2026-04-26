<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository extends BaseRepository
{
    public function __construct(Category $model) {
        parent::__construct($model);
    }

    public function getSystemCategory(): ?Collection 
    {
        return Category::where('user_id', 1)
            ->where('is_active', true)
            ->latest()
            ->get();   
    }

    public function getMine(): ?Collection
    {
        return Category::where('user_id', auth()->id())
        ->latest()
        ->get();
    }

    
}