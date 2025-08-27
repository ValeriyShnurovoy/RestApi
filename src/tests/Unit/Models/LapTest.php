<?php

declare(strict_types=1);

namespace Tests\Unit\Models;

use App\Domain\Laps\Lap as LapDomain;
use App\Models\Collections\LapCollection;
use App\Models\Lap;
use PHPUnit\Framework\TestCase;

class LapTest extends TestCase
{
    public function test_to_domain_returns_correct_instance(): void
    {
        $lap = new Lap([
            'lap_number' => 5,
            'driver_number' => 44,
            'duration_sector1' => 30.123,
            'duration_sector2' => 28.456,
            'duration_sector3' => 32.789,
        ]);

        $domain = $lap->toDomain();

        $this->assertInstanceOf(LapDomain::class, $domain);
        $this->assertSame(5, $domain->lapNumber);
        $this->assertSame(44, $domain->driverNumber);
        $this->assertSame(30.123, $domain->durationSector1);
        $this->assertSame(28.456, $domain->durationSector2);
        $this->assertSame(32.789, $domain->durationSector3);
    }

    public function test_new_collection_returns_lap_collection(): void
    {
        $lap = new Lap([
            'lap_number' => 1,
            'driver_number' => 7,
            'duration_sector1' => 10.0,
            'duration_sector2' => 20.0,
            'duration_sector3' => 30.0,
        ]);

        $collection = $lap->newCollection([$lap]);

        $this->assertInstanceOf(LapCollection::class, $collection);
        $this->assertCount(1, $collection);
        $this->assertTrue($collection->first()->is($lap));
    }

    public function test_fillable_and_casts_are_defined(): void
    {
        $lap = new Lap();

        $this->assertEqualsCanonicalizing(
            ['lap_number', 'driver_number', 'duration_sector1', 'duration_sector2', 'duration_sector3'],
            $lap->getFillable()
        );

        $this->assertArrayHasKey('lap_number', $lap->getCasts());
        $this->assertArrayHasKey('driver_number', $lap->getCasts());
        $this->assertArrayHasKey('duration_sector1', $lap->getCasts());
    }
}
