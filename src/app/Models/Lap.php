<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Laps\Lap as LapDomain;
use App\Models\Collections\LapCollection;
use Illuminate\Database\Eloquent\Model;

class Lap extends Model
{
    protected $fillable = [
        'lap_number',
        'driver_number',
        'duration_sector1',
        'duration_sector2',
        'duration_sector3'
    ];

    protected $casts = [
        'lap_number' => 'integer',
        'driver_number' => 'integer',
        'duration_sector1' => 'float',
        'duration_sector2' => 'float',
        'duration_sector3' => 'float',
    ];

    public function toDomain(): LapDomain
    {
        return new LapDomain(
            lapNumber: (int) $this->lap_number,
            driverNumber: (int) $this->driver_number,
            durationSector1: (float) $this->duration_sector1,
            durationSector2: (float) $this->duration_sector2,
            durationSector3: (float) $this->duration_sector3,
        );
    }

    public function newCollection(array $models = []): LapCollection
    {
        return new LapCollection($models);
    }
}
