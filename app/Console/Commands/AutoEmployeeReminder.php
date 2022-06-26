<?php

namespace App\Console\Commands;

use App\Mail\EmployeeReminder;
use App\Models\CleaningSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AutoEmployeeReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:employeereminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $UserForActiveDate = CleaningSchedule::with('user1','user2')->select('user1_id','user2_id')->where('monitoringDate',Carbon::today()->format('Y-m-d'))->first();
        $users = [$UserForActiveDate->user1,$UserForActiveDate->user2];
            foreach ($users as $user) {
                Mail::to($user->email)->send(new EmployeeReminder($user));
            }
        return 0;
    }
}
