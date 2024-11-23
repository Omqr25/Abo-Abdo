<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\RepositoryServiceProvider::class,
    Barryvdh\Debugbar\ServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
    Clockwork\Support\Laravel\ClockworkServiceProvider::class,
    Intervention\Image\ImageServiceProvider::class,
];
