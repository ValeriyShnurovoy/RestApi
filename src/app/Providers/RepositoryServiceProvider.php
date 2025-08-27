<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Laps\LapRepositoryInterface;
use App\Infrastructure\Laps\LapRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(LapRepositoryInterface::class, LapRepository::class);
    }
}
