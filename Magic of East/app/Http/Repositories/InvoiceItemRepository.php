<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\InvoiceItemRepositoryInterface;
use App\Models\InvoiceItem;

class InvoiceItemRepository extends BaseRepository implements InvoiceItemRepositoryInterface
{
    public function __construct(InvoiceItem $model)
    {
        parent::__construct($model);
    }
}
