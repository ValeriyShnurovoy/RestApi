<?php

declare(strict_types=1);

namespace Tests\Unit\Application\Laps;


use App\Application\Laps\FetchLapsService;
use App\Domain\Laps\Lap;
use App\Domain\Laps\LapRepositoryInterface;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class FetchLapsServiceTest extends TestCase
{
    public function testExecuteSavesLapsToRepository(): void
    {
        $fakeApiResponse = [
            [
                'lap_number' => 1,
                'driver_number' => 44,
                'duration_sector_1' => 30.5,
                'duration_sector_2' => 32.1,
                'duration_sector_3' => 31.7,
            ],
            [
                'lap_number' => 2,
                'driver_number' => 44,
                'duration_sector_1' => 31.0,
                'duration_sector_2' => 32.5,
                'duration_sector_3' => 31.2,
            ],
        ];

        Http::fake([
            'api.openf1.org/v1/laps*' => Http::response($fakeApiResponse, 200)
        ]);

        $repository = Mockery::mock(LapRepositoryInterface::class);
        $repository->expects('saveMany')->once()->withArgs(function ($laps) use ($fakeApiResponse) {
            return count($laps) === 2
                && $laps[0] instanceof Lap
                && $laps[0]->lapNumber === 1
                && $laps[1]->lapNumber === 2;
        });

        $service = new FetchLapsService($repository);
        $service->execute(9939);
    }

    public function testExecuteThrowsExceptionWhenApiFails(): void
    {
        Http::fake([
            'api.openf1.org/v1/laps*' => Http::response([], 500)
        ]);

        $repository = Mockery::mock(LapRepositoryInterface::class);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Failed to fetch laps from API');

        $service = new FetchLapsService($repository);
        $service->execute(9939);
    }
}
