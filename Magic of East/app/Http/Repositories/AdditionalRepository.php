<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AdditionalRepositoryInterface;
use App\Models\Additional;

class AdditionalRepository extends BaseRepository implements AdditionalRepositoryInterface
{
    public function __construct(Additional $model)
    {
        parent::__construct($model);
    }
}
