<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BaseRepositoryInterface;
use App\Http\Services\Filter\FilterService;
use App\Http\Services\OrderService;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index(array $with = [],  $order = false)
    {
        $query = $this->model::query();

        if (!empty($with)) {
            $query->with($with);
        }

        if (request()->has('filter') || request()->has('sort')) {
            $func = class_basename($this->model);
            return FilterService::$func();
        }
        if ($order) {
            $func = class_basename($this->model);
            return OrderService::$func();
        }
        return $query->simplePaginate(10);
    }

    public function show($id, array $with = [])
    {
        $query = $this->model::query();

        if (!empty($with)) {
            $query->with($with);
        }

        $data = $query->find($id);
        if ($data == null) throw new Exception('No such Record', 404);
        return $data;
    }

    public function store(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        if ($record == null) throw new Exception('No such Record', 404);
        $record->update($data);
        return $record;
    }

    public function destroy($id)
    {
        $record = $this->model::find($id);
        if ($record == null) throw new Exception('No such Record', 404);
        return $record->delete();
    }

    public function showDeleted()
    {
        return $this->model::onlyTrashed()->simplePaginate(10);
    }

    public function restore(array $ids)
    {
        foreach ($ids as $id) {
            $model = $this->model::onlyTrashed()->find($id);
            if ($model) $model->restore();
        }
    }
}