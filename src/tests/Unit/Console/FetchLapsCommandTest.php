<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Tests\TestCase;
use App\Application\Laps\FetchLapsService;
use Mockery;

class FetchLapsCommandTest extends TestCase
{
    public function testCommandCallsServiceExecute(): void
    {
        $sessionKey = 9939;

        $serviceMock = Mockery::mock(FetchLapsService::class);
        $serviceMock->shouldReceive('execute')
                    ->once()
                    ->with($sessionKey);

        $this->app->instance(FetchLapsService::class, $serviceMock);

        $this->artisan('laps:fetch', ['sessionKey' => $sessionKey])
             ->expectsOutput('Laps fetched successfully.')
             ->assertExitCode(0);
    }

    public function testCommandHandlesServiceException(): void
    {
        $sessionKey = 9939;

        $serviceMock = Mockery::mock(FetchLapsService::class);
        $serviceMock->shouldReceive('execute')
                    ->once()
                    ->with($sessionKey)
                    ->andThrow(new \RuntimeException('API error'));

        $this->app->instance(FetchLapsService::class, $serviceMock);

        $this->artisan('laps:fetch', ['sessionKey' => $sessionKey])
             ->expectsOutputToContain('API error')
             ->assertExitCode(1);
    }
}
