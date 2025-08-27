<?php

declare(strict_types=1);

namespace App\Domain\Laps;

class Lap
{
    public function __construct(
        public readonly int $lapNumber,
        public readonly int $driverNumber,
        public readonly float $durationSector1,
        public readonly float $durationSector2,
        public readonly float $durationSector3,
    ) {}

    public function getTotalDuration(): float
    {
        return $this->durationSector1 + $this->durationSector2 + $this->durationSector3;
    }
}
