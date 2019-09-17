<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\StreamCheck',
        'App\Console\Commands\ChatClean',
        'App\Console\Commands\HTMLToBbcode'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('backup:run')->daily()->at('23:00');
        $schedule->command('streamActiveCheck:start')->everyMinute();//->appendOutputTo(storage_path('logs/test.log'))
        $schedule->command('ChatMessageClean:start')->daily()->at('23:00');
        $schedule->command('replays:clean_files')->daily()->at('01:00');
        $schedule->command('convertHtmlToBbcode')->daily()->at('01:00');

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
