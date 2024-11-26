<?php

namespace App\Http\Services\Filter;

use App\Models\Classification;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Group;
use App\Models\Invoice;
use App\Models\InvoiceGroup;
use App\Models\Item;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Enums\FilterOperator;
use Spatie\QueryBuilder\QueryBuilder;

class FilterService
{
    public static function classification()
    {
        $data = QueryBuilder::for(Classification::class)
            ->allowedFilters(['name'])
            ->simplePaginate(10);
        return $data;
    }

    public static function group()
    {
        $data = QueryBuilder::for(Group::class)
            ->allowedFilters([
                'name',
                // AllowedFilter::scope('color'),
                AllowedFilter::custom('before', new CreatedDateFilter('before')),
                AllowedFilter::custom('after', new CreatedDateFilter('after')),
                AllowedFilter::exact('classification', 'classification_id'),
            ])
            ->simplePaginate(10);
        return $data;
    }

    public static function item()
    {
        $data = QueryBuilder::for(Item::class)
            ->allowedFilters([
                'name',
                AllowedFilter::exact('group', 'group_id'),
                AllowedFilter::operator('height', FilterOperator::DYNAMIC),
                AllowedFilter::operator('width', FilterOperator::DYNAMIC),
                AllowedFilter::operator('depth', FilterOperator::DYNAMIC),
                AllowedFilter::custom('before', new CreatedDateFilter('before')),
                AllowedFilter::custom('after', new CreatedDateFilter('after')),
            ])
            ->simplePaginate(10);
        return $data;
    }

    public static function customer()
    {
        $data = QueryBuilder::for(Customer::class)
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::partial('mobile', 'phonenumber'),
                /*AllowedFilter::scope('address'),*/   // COMING SOON!
                AllowedFilter::custom('before', new CreatedDateFilter('before')),
                AllowedFilter::custom('after', new CreatedDateFilter('after')),
            ])
            ->simplePaginate(10);
        return $data;
    }

    public static function invoice()
    {
        $data = QueryBuilder::for(Invoice::class)
            ->allowedFilters([
                AllowedFilter::exact('customer', 'customer_id'),
                AllowedFilter::exact('delivery', 'with_delivery'),
                AllowedFilter::operator('total_net_price', FilterOperator::DYNAMIC),
                AllowedFilter::operator('total_sell_price', FilterOperator::DYNAMIC),
                AllowedFilter::custom('before', new CreatedDateFilter('before')),
                AllowedFilter::custom('after', new CreatedDateFilter('after')),
            ])
            ->simplePaginate(10);
        return $data;
    }

    public static function invoiceGroup()
    {
        $data = QueryBuilder::for(InvoiceGroup::class)
            ->allowedFilters([
                AllowedFilter::exact('invoice', 'invoice_id'),
                AllowedFilter::exact('group', 'group_id'),
                AllowedFilter::operator('net_price', FilterOperator::DYNAMIC),
                AllowedFilter::operator('sell_price', FilterOperator::DYNAMIC),
                AllowedFilter::operator('quantity', FilterOperator::DYNAMIC),
            ])
            ->simplePaginate(10);
        return $data;
    }

    public static function employee()
    {
        $data = QueryBuilder::for(Employee::class)
            ->allowedFilters([
                AllowedFilter::scope('name'),
                AllowedFilter::partial('mobile', 'phonenumber'),
                /*AllowedFilter::scope('address'),*/   // COMING SOON!
                /*AllowedFilter::scope('position'),*/   // ???????????
                AllowedFilter::operator('salary', FilterOperator::DYNAMIC),
            ])
            ->simplePaginate(10);
        return $data;
    }
}
