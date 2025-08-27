<?php

declare(strict_types=1);

namespace App\Infrastructure\Laps;

use App\Domain\Laps\Lap;
use App\Domain\Laps\Lap as DomainLap;
use App\Domain\Laps\LapRepositoryInterface;
use App\Models\Lap as LapModel;

class LapRepository implements LapRepositoryInterface
{
    public function save(Lap $lap): void
    {
        LapModel::updateOrCreate(
            ['lap_number' => $lap->lapNumber, 'driver_number' => $lap->driverNumber],
            [
                'duration_sector1' => $lap->durationSector1,
                'duration_sector2' => $lap->durationSector2,
                'duration_sector3' => $lap->durationSector3,
            ]
        );
    }

    public function saveMany(array $laps): void
    {
        foreach ($laps as $lap) {
            $this->save($lap);
        }
    }

    /**
     * @param int[]|null $driverNumbers
     * @param int[]|null $lapRange [start, end]
     * @return \App\Domain\Laps\Lap[]
     */
    public function getLaps(?array $driverNumbers = null, ?array $lapRange = null): array
    {
        $query = LapModel::query();

        if (!empty($driverNumbers)) {
            $query->whereIn('driver_number', $driverNumbers);
        }

        if (!empty($lapRange) && count($lapRange) === 2) {
            [$start, $end] = $lapRange;
            $query->whereBetween('lap_number', [$start, $end]);
        }

        return $query->get()->toDomain();
    }
}
