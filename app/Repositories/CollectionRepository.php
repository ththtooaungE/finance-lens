<?php

namespace App\Repositories;

use App\Models\Collection;

class CollectionRepository extends BaseRepository
{
    public function __construct(Collection $model) {
        parent::__construct($model);
    }
    
}