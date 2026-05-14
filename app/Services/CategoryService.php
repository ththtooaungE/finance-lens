<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Override;

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

    public function getSystemCategories() 
    {
        return $this->repository->getSystemCategories();
    }

    public function getMine() 
    {
        return $this->repository->getMyCategories();
    }

    #[Override]
    public function delete(int|string $id): bool
    {
        $category = $this->repository->find($id);

        // Check if the category is used in the cost
        if ($category->costs()->exists()) {
            throw new \Exception('The category is used in a cost!');
        }

        // Check if the category is used in the collection
        if($category->collections()->exists()) {
            throw new \Exception('The category is used in a collection!');
        }
        
        return parent::delete($id);
    }
}