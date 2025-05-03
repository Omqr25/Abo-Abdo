<?php

namespace App\Http\Repositories;
use App\Http\Interfaces\SettingsRepositoryInterface;
use App\Models\Settings;

class SettingsRepository extends BaseRepository implements SettingsRepositoryInterface
{
    public function __construct(Settings $model)
    {
        parent::__construct($model);
    }
}