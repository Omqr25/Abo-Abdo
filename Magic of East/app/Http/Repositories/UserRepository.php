<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserRepositoryInterface;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\verifyCode;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function ForgotPassword($id)
    {

        $email = User::find($id)->email;

        DB::table('verify_codes')->where('email', $email)->delete();
        $code_v = mt_rand(10000, 99999);


        DB::table('verify_codes')->insert([
            'email' => $email,
            'code' => $code_v,
        ]);

        Mail::to($email)->send(new ResetPasswordMail($code_v));

        return $email;
    }

    public function CheckCode($ip, $id, $data)
    {
        $email = User::find($id)->email;

        $code = verifyCode::where('email', $email)->first();

        if ($code['code'] != $data['code']) return 0;

        $code->update([
            'checked' => true,
            'ip' => $ip
        ]);
        return 1;
    }

    public function ChangePassword($ip, $id, $data)
    {
        $user = User::find($id);

        $code = verifyCode::where('email', $user['email'])->first();

        if ($code['checked'] == false) return 0;
        if ($code['ip'] != $ip) return 1;
        if ($data['passwordRet'] != $data['password']) return 2;

        $user->update(['password' => Hash::make($data['password'])]);

        DB::table('verify_codes')->where('email', $user['email'])->delete();

        return 3;
    }
}
