<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Domain\Laps\Lap as LapDomain;
use App\Models\Lap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LapFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_lap_can_be_created_and_converted_to_domain(): void
    {
        $lap = Lap::create([
            'lap_number' => 12,
            'driver_number' => 7,
            'duration_sector1' => 29.123,
            'duration_sector2' => 27.456,
            'duration_sector3' => 31.789,
        ]);

        $this->assertDatabaseHas('laps', [
            'lap_number' => 12,
            'driver_number' => 7,
        ]);

        $domain = $lap->toDomain();

        $this->assertInstanceOf(LapDomain::class, $domain);
        $this->assertSame(12, $domain->lapNumber);
        $this->assertSame(7, $domain->driverNumber);
        $this->assertSame(29.123, $domain->durationSector1);
        $this->assertSame(27.456, $domain->durationSector2);
        $this->assertSame(31.789, $domain->durationSector3);
    }
}
