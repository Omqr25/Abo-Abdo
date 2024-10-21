<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
}
