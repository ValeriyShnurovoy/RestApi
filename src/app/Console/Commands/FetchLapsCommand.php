<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Application\Laps\FetchLapsService;

class FetchLapsCommand extends Command
{
    protected $signature = 'laps:fetch {sessionKey}';
    protected $description = 'Fetch laps from OpenF1 API and save to database';

    public function handle(FetchLapsService $service)
    {
        $sessionKey = (int) $this->argument('sessionKey');
        try {
            $service->execute($sessionKey);
            $this->info('Laps fetched successfully.');
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
            return self::FAILURE;
        }
    }
}
