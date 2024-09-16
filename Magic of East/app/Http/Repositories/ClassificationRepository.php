<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\ClassificationRepositoryInterface;
use App\Models\Classification;

class ClassificationRepository extends BaseRepository implements ClassificationRepositoryInterface
{
    public function __construct(Classification $model)
    {
        parent::__construct($model);
    }
}
