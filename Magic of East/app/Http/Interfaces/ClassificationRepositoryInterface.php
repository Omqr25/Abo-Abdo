<?php

namespace App\Http\Interfaces;

interface ClassificationRepositoryInterface extends BaseRepositoryInterface
{
    public function getGroups();
}
