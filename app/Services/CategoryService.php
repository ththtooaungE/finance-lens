<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use App\Repositories\CategoryRepository;

class CategoryService extends BaseService
{
    /**
     * CategoryService constructor.
     *
     * @param CategoryRepository $repository
     */
    public function __construct(CategoryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getSystemCategory() 
    {
        return $this->repository->getSystemCategory();
    }

    public function getMine() 
    {
        return $this->repository->getMine();
    }
}