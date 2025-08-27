<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Application\Laps\GroupedLapsService;
use App\Http\Requests\Laps\GroupedLapsRequest;

class LapsController extends Controller
{
    public function grouped(GroupedLapsRequest $request, GroupedLapsService $service)
    {
        $filters = $request->validated();

        $result = $service->execute($filters);

        return response()->json($result);
    }
}
