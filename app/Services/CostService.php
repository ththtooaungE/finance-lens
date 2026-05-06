<?php

namespace App\Services;

use App\Models\Collection;
use App\Repositories\CostRepository;
use Illuminate\Database\Eloquent\Model;

class CostService extends BaseService
{
    public function __construct(CostRepository $repository)
    {
        return parent::__construct($repository);
    }

    public function findCollectionById(int $id): Model {
        return Collection::find($id);
    }

    public function findCollectionByCostId(int $id): Model {
        return Collection::whereHas('costs', function ($query) use ($id) {
            $query->where('id', $id);
        })->first();
    }

    public function findCategoryById(int $id): Model {
        return Collection::find($id);
    }
}