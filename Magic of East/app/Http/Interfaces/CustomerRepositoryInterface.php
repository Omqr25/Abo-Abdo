<?php

namespace App\Http\Interfaces;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function getGroups($customer_id);
}