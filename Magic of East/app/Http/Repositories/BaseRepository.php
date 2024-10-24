<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\BaseRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return $this->model::simplePaginate(10);
    }

    public function show($id)
    {
        $data = $this->model::find($id);
        if ($data == null) throw new Exception('No such Record');
        return $data;
    }

    public function store(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model::find($id);
        if ($record == null) throw new Exception('No such Record');
        $record->update($data);
        return $record;
    }

    public function destroy($id)
    {
        $record = $this->model::find($id);
        if ($record == null) throw new Exception('No such Record');
        return $record->delete();
    }

    public function showDeleted()
    {
        return $this->model::onlyTrashed()->simplePaginate(10);
    }

    public function restore(array $ids)
    {
        foreach($ids as $id)
            {
                $model = $this->model::onlyTrashed()->find($id);
                if($model) $model->restore();
            }
    }
}