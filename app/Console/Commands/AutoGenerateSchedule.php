<?php

namespace App\Console\Commands;

use App\Jobs\NotifyAllUsersJob;
use App\Models\CleaningSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoGenerateSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auto:generateschedule';

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
        $allUsers = User::all()->shuffle()->toArray(); // List of all users in random order
        if (count($allUsers)%2!==0) {
        $allUsers = [...$allUsers,...$allUsers];
        }

        $date = Carbon::today();
        for($i=0;$i<count($allUsers);$i=$i+2) {
            if ($date->dayOfWeek == 6) {
                $date->addDay(2);
            }
            CleaningSchedule::query()->create([
                'monitoringDate' => $date,
                'user1_id' =>  $allUsers[$i]['id'],
                'user2_id' =>  $allUsers[$i+1]['id'],
            ]);
            $date->addDay(1);
        }
        dispatch(new NotifyAllUsersJob());
        return 0;
    }
}
