<?php

declare(strict_types=1);

namespace Tests\Unit\Models\Collections;

use App\Domain\Laps\Lap as LapDomain;
use App\Models\Collections\LapCollection;
use App\Models\Lap;
use PHPUnit\Framework\TestCase;

class LapCollectionTest extends TestCase
{
    public function test_to_domain_returns_array_of_domain_objects(): void
    {
        $laps = [
            new Lap([
                'lap_number' => 1,
                'driver_number' => 44,
                'duration_sector1' => 30.1,
                'duration_sector2' => 28.2,
                'duration_sector3' => 32.3,
            ]),
            new Lap([
                'lap_number' => 2,
                'driver_number' => 77,
                'duration_sector1' => 31.1,
                'duration_sector2' => 29.2,
                'duration_sector3' => 33.3,
            ]),
        ];

        $collection = new LapCollection($laps);
        $domains = $collection->toDomain();

        $this->assertCount(2, $domains);
        $this->assertInstanceOf(LapDomain::class, $domains[0]);
        $this->assertInstanceOf(LapDomain::class, $domains[1]);

        $this->assertSame(1, $domains[0]->lapNumber);
        $this->assertSame(44, $domains[0]->driverNumber);

        $this->assertSame(2, $domains[1]->lapNumber);
        $this->assertSame(77, $domains[1]->driverNumber);
    }
}
