<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        //Рассылка непринятых заказов
        $schedule->command('app:send-not-aссepted')->cron('0 21 * * *');
        //Выполнение очередей
        $schedule->command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();
        //Генерация YML
        $schedule->command('export:products yandex_feed.xml')->cron('0 0 1 * *');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
