<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Laps;

use App\Domain\Laps\Lap as DomainLap;
use App\Infrastructure\Laps\LapRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LapRepositoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    private LapRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new LapRepository();
    }

    public function test_save_and_getLaps(): void
    {
        $lap = new DomainLap(
            lapNumber: 1,
            driverNumber: 44,
            durationSector1: 30.1,
            durationSector2: 28.2,
            durationSector3: 32.3
        );

        $this->repository->save($lap);

        $laps = $this->repository->getLaps([44], [1, 1]);

        $this->assertCount(1, $laps);
        $this->assertInstanceOf(DomainLap::class, $laps[0]);
        $this->assertSame(1, $laps[0]->lapNumber);
        $this->assertSame(44, $laps[0]->driverNumber);
        $this->assertSame(30.1, $laps[0]->durationSector1);
    }

    public function test_saveMany_and_getLaps_range(): void
    {
        $laps = [
            new DomainLap(lapNumber: 1, driverNumber: 44, durationSector1: 10, durationSector2: 20, durationSector3: 30),
            new DomainLap(lapNumber: 2, driverNumber: 44, durationSector1: 11, durationSector2: 21, durationSector3: 31),
            new DomainLap(lapNumber: 3, driverNumber: 7, durationSector1: 12, durationSector2: 22, durationSector3: 32),
        ];

        $this->repository->saveMany($laps);

        $driverLaps = $this->repository->getLaps([44]);
        $this->assertCount(2, $driverLaps);

        $rangeLaps = $this->repository->getLaps(null, [2, 3]);
        $this->assertCount(2, $rangeLaps);

        foreach ($rangeLaps as $lap) {
            $this->assertInstanceOf(DomainLap::class, $lap);
        }
    }
}
