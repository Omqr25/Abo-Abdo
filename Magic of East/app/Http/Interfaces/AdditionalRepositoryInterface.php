<?php

namespace App\Http\Interfaces;

interface AdditionalRepositoryInterface extends BaseRepositoryInterface
{
    public function showAdditionals($id, $date);
}
