<?php

declare(strict_types=1);

namespace App\Models\Collections;

use Illuminate\Database\Eloquent\Collection;
use App\Domain\Laps\Lap as LapDomain;
use App\Models\Lap as LapModel;

class LapCollection extends Collection
{
    /**
     * @return LapDomain[]
     */
    public function toDomain(): array
    {
        return $this->map(fn(LapModel $model) => $model->toDomain())->all();
    }
}
