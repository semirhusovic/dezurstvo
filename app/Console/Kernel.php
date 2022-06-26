<?php

namespace App\Console;

use App\Models\CleaningSchedule;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->command('auto:generateschedule')->everyMinute()->when(function(){
            $today = Carbon::today();
            $latestDateFromDatabase = CleaningSchedule::latest()->first();
            if($latestDateFromDatabase == null) {
                $latestDateFromDatabase = Carbon::today();
            } else {
                $latestDateFromDatabase = Carbon::parse($latestDateFromDatabase->monitoringDate)->addDay(1);
            }
            return $today == $latestDateFromDatabase;
        });
        $schedule->command('auto:employeereminder')->everyMinute('9','15');
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
