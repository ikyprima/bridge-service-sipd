<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
     
        // $schedule->call(function () {
        //         Log::info('ok');
        //     })->everyTwoMinutes();
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@hapusHalaman')
        ->daily();
        

        
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi')->dailyAt('01:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi')->dailyAt('08:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi')->dailyAt('10:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi') ->dailyAt('12:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi')->dailyAt('14:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi')->dailyAt('15:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi')->dailyAt('16:00');
        $schedule->call('Modules\InfoSp2d\Http\Controllers\InfoSp2dController@importSp2dVerifikasi') ->dailyAt('20:00');

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
