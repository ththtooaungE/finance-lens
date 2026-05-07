<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\CollectionRepository;
use Illuminate\Database\Eloquent\Model;
use Override;

class CollectionService extends BaseService
{
    protected BaseRepository $repository;
    
    public function __construct(CollectionRepository $repository) {
        parent::__construct($repository);
    }

    #[Override]
    public function create(array $data): Model
    {
        $collection = parent::create($data);
        $collection->categories()->sync($data['category_ids'] ?? []);
        return $collection;
    }

    #[Override]
    public function update(int|string $int, array $data): bool
    {
        $return = parent::update($int, $data);
        $collection = $this->repository->find($int);
        $collection = $collection->categories()->sync($data['category_ids'] ?? []);
        return $return;
    }

    #[Override]
    public function delete(int|string $id): bool
    {        
        $collection = $this->repository->find($id);
        $collection->categories()->detach();
        return parent::delete($id);
    }
}