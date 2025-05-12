<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Requests\Auth\ForgetPasswordRequest;
use App\Mail\ResetPasswordMail;
use App\Mail\SendCodeResetPassword;
use App\Models\User;
use App\Models\verifyCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function ForgotPassword($data)
    {

        $user = DB::table('users')->where('email', $data['email'])->first();



        DB::table('verify_codes')->where('email', $data['email'])->delete();
        $code_v = mt_rand(10000, 99999);        


        DB::table('verify_codes')->insert([
            'email' => $data['email'],
            'code' => $code_v,

        ]);

        dump($code_v);

        // Send email to user
        Mail::to($data['email'])->send(new ResetPasswordMail($code_v));
        
        dump('hiiiii');


        return $user;
    }
}
