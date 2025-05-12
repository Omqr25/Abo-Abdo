<?php

namespace App\Http\Interfaces;

use App\Http\Requests\Auth\ForgetPasswordRequest;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function ForgotPassword($data);
}