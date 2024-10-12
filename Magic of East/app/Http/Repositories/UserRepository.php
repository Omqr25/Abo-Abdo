<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Models\User;

class userRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }
}
