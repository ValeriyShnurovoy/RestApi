<?php

declare(strict_types=1);

namespace App\Application\Laps;

use App\Domain\Laps\LapRepositoryInterface;

class GroupedLapsService
{
    public function __construct(private LapRepositoryInterface $repository) {}

    /**
     * @param array $filters ['driver_numbers' => [], 'sum_time' => bool, 'lap_range' => [start, end]]
     * @return array
     */
    public function execute(array $filters): array
    {
        $laps = $this->repository->getLaps(
            driverNumbers: $filters['driver_numbers'] ?? null,
            lapRange: $filters['lap_range'] ?? null
        );

        $grouped = [];

        foreach ($laps as $lap) {
            $grouped[$lap->lapNumber][$lap->driverNumber] = $filters['sum_time'] ?? false
                ? $lap->getTotalDuration()
                : [
                    'sector_1' => $lap->durationSector1,
                    'sector_2' => $lap->durationSector2,
                    'sector_3' => $lap->durationSector3,
                ];
        }

        return $grouped;
    }
}
