<?php

namespace App\Http\Interfaces;

interface BaseRepositoryInterface
{
    public function index(array $with = [], $order = false);
    public function show($id, array $with = []);
    public function store(array $data);
    public function update($id, array $data);
    public function destroy($id);
    public function showDeleted();
    public function restore(array $ids);
}
