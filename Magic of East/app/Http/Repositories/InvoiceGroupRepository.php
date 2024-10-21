<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\InvoiceGroupRepositoryInterface;
use App\Models\InvoiceGroup;

class InvoiceGroupRepository extends BaseRepository implements InvoiceGroupRepositoryInterface
{
    public function __construct(InvoiceGroup $model)
    {
        parent::__construct($model);
    }
}
