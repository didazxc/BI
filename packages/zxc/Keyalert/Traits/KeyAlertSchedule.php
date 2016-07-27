<?php

namespace Zxc\Keyalert\Traits;
use Illuminate\Console\Scheduling\Schedule;

class KeyAlertSchedule
{
    public static function schedule(Schedule $schedule)
    {
        $logfile=storage_path('logs/keyalert_update.log');
        $schedule->command('keyalert:update realtime')->everyMinute()->withoutOverlapping()->sendOutputTo($logfile);
        $schedule->command('keyalert:update hourly')->hourly()->withoutOverlapping()->sendOutputTo($logfile);
        $schedule->command('keyalert:update daily')->dailyAt('7:00')->withoutOverlapping()->sendOutputTo($logfile);
        $schedule->command('keyalert:update weekly')->weekly()->mondays()->at('7:00')->withoutOverlapping()->sendOutputTo($logfile);
        $schedule->command('keyalert:update monthly')->cron('0 7 1 * *')->withoutOverlapping()->sendOutputTo($logfile);
    }
    
}
