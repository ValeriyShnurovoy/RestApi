<?php

declare(strict_types=1);

namespace App\Application\Laps;

use App\Domain\Laps\Lap;
use App\Domain\Laps\LapRepositoryInterface;
use Illuminate\Support\Facades\Http;

class FetchLapsService
{
    public function __construct(private LapRepositoryInterface $repository) {}

    public function execute(int $sessionKey): void
    {
        $response = Http::get("https://api.openf1.org/v1/laps", [
            'session_key' => $sessionKey
        ]);

        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch laps from API');
        }

        $lapsData = $response->json();
        $laps = [];

        foreach ($lapsData as $lap) {
            $laps[] = new Lap(
                lapNumber: (int) $lap['lap_number'],
                driverNumber: (int) $lap['driver_number'],
                durationSector1: (float) $lap['duration_sector_1'],
                durationSector2: (float) $lap['duration_sector_2'],
                durationSector3: (float) $lap['duration_sector_3'],
            );
        }

        $this->repository->saveMany($laps);
    }
}
