<?php

declare(strict_types=1);

namespace Tests\Feature\Models\Collections;

use App\Domain\Laps\Lap as LapDomain;
use App\Models\Collections\LapCollection;
use App\Models\Lap;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LapCollectionFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_to_domain_with_database_records(): void
    {
        $lap1 = Lap::create([
            'lap_number' => 1,
            'driver_number' => 44,
            'duration_sector1' => 30.1,
            'duration_sector2' => 28.2,
            'duration_sector3' => 32.3,
        ]);

        $lap2 = Lap::create([
            'lap_number' => 2,
            'driver_number' => 77,
            'duration_sector1' => 31.1,
            'duration_sector2' => 29.2,
            'duration_sector3' => 33.3,
        ]);

        $collection = LapCollection::make(Lap::all());
        $domains = $collection->toDomain();

        $this->assertCount(2, $domains);
        $this->assertInstanceOf(LapDomain::class, $domains[0]);
        $this->assertInstanceOf(LapDomain::class, $domains[1]);
    }
}
