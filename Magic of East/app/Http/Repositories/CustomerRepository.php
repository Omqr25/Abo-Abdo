<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Models\Invoice;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function __construct(Customer $model)
    {
        parent::__construct($model);
    }
    public function getGroups($customer_id)
    {
        $invoices = Invoice::with(['groups.media'])->where('customer_id', $customer_id)->get();
        $media = $invoices->flatMap(function ($invoice) {
            return $invoice->groups->flatMap(function ($group) {
                return $group->media;
            });
        });
        return $media;
    }
}
