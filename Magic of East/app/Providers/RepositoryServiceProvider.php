<?php

namespace App\Providers;

use App\Http\Interfaces\BaseRepositoryInterface;
use App\Http\Repositories\BaseRepository;
use App\Http\Interfaces\ClassificationRepositoryInterface;
use App\Http\Repositories\ClassificationRepository;
use App\Http\Interfaces\ItemRepositoryInterface;
use App\Http\Repositories\ItemRepository;
use App\Http\Interfaces\GroupRepositoryInterface;
use App\Http\Repositories\GroupRepository;
use App\Http\Interfaces\InvoiceGroupRepositoryInterface;
use App\Http\Repositories\InvoiceGroupRepository;
use App\Http\Interfaces\InvoiceRepositoryInterface;
use App\Http\Repositories\InvoiceRepository;
use App\Http\Interfaces\UserRepositoryInterface;
use App\Http\Repositories\UserRepository;
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
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
        $this->app->bind(ItemRepositoryInterface::class, ItemRepository::class);
        $this->app->bind(InvoiceRepositoryInterface::class, InvoiceRepository::class);
        $this->app->bind(InvoiceGroupRepositoryInterface::class, InvoiceGroupRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
