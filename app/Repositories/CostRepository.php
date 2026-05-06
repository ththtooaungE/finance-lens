<?php

namespace App\Repositories;

use App\Models\Cost;
use Illuminate\Database\Eloquent\Model;
use Override;

class CostRepository extends BaseRepository
{
    public function __construct(Cost $cost)
    {
        return parent::__construct($cost);
    }
}