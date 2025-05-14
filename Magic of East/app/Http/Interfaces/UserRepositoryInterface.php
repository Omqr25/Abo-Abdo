<?php

namespace App\Http\Interfaces;

use App\Http\Requests\Auth\ForgetPasswordRequest;

interface UserRepositoryInterface extends BaseRepositoryInterface
{
    public function ForgotPassword($id);
    public function CheckCode($ip, $id, $data);
    public function ChangePassword($ip, $id, $data);
}
