<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Zxc\Keylib\Traits\KeyLibSchedule;
use Zxc\Keysql\Traits\KeySqlSchedule;
use Zxc\Keyalert\Traits\KeyAlertSchedule;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        KeyLibSchedule::schedule($schedule);
        KeySqlSchedule::schedule($schedule);
        KeyAlertSchedule::schedule($schedule);
    }
}
