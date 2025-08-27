<?php

declare(strict_types=1);

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;

class Kernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('laps:fetch 9939')->cron('0 */2 * * *');
    }
}
