<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\InvoiceRepositoryInterface;
use App\Http\Resources\InvoiceResource;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\InvoiceGroup;

class InvoiceRepository extends BaseRepository implements InvoiceRepositoryInterface
{
    public function __construct(Invoice $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {
        $total_net_price = 0;
        if (isset($data['groups'])) {
            foreach ($data['groups'] as $group) {
                $total_net_price += Group::find($group['id'])->net_price;
            }
        }
        $invoice = Invoice::create([
            'customer_id' => $data['customer_id'],
            'total_net_price' => $total_net_price,
            'total_sell_price' => $data['total_sell_price'],
            'notes' =>  $data['notes'] ?? null,
        ]);
        $invoice = new InvoiceResource($invoice);
        $groups = [];
        if (isset($data['groups'])) {
            foreach ($data['groups'] as $group) {
                $invoicegroup = InvoiceGroup::create([
                    'invoice_id' => $invoice->id,
                    'group_id' => $group['id'],
                    'quantity' => $group['quantity']
                ]);
                $groups[] = [
                    'id' => $invoicegroup->group_id,
                    'quantity' => $invoicegroup->quantity
                ];
            }
        }
        $invoice->additional(['groups' => $groups]);
        return $invoice;
    }
}
