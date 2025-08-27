<?php

declare(strict_types=1);

namespace App\Domain\Laps;

interface LapRepositoryInterface
{
    public function save(Lap $lap): void;

    public function saveMany(array $laps): void;

    /**
     * @param array|null $driverNumbers
     * @param array|null $lapRange [start, end]
     * @return Lap[]
     */
    public function getLaps(?array $driverNumbers = null, ?array $lapRange = null): array;
}
