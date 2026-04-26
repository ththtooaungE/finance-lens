<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

abstract class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository) 
    {
        $this->repository = $repository;    
    }

    public function all(): Collection
    {
        return $this->repository->all();
    }

    public function find(int|string $id)
    {
        return $this->repository->find($id);    
    }

    public function create(array $data) 
    {
        return $this->repository->create($data);    
    }

    public function update(int|string $id, array $data) 
    {
        return $this->repository->update($id, $data);    
    }

    public function delete(int|string $id) {
        return $this->repository->delete($id);
    }

    public function paginate(int $perPage = 15) : LengthAwarePaginator 
    {
        return $this->repository->paginate($perPage);    
    }
}