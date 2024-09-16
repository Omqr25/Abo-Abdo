<?php

namespace App\Providers;

use App\Http\Interfaces\BaseRepositoryInterface;
use App\Http\Interfaces\ClassificationRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use App\Http\Repositories\ClassificationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(ClassificationRepositoryInterface::class, ClassificationRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
