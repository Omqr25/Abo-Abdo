<?php

namespace App\Http\Interfaces;

interface BaseRepositoryInterface
{
    public function index();
    public function show($id);
    public function store(array $data);
    public function update($id, array $data);
    public function destroy($id);
    public function showDeleted();
    public function restore(array $ids);
}
