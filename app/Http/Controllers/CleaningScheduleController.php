<?php

namespace App\Http\Controllers;

use App\Exports\ScheduleExport;
use App\Jobs\NotifyAllUsersJob;
use App\Mail\EmployeeReminder;
use App\Models\CleaningSchedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class CleaningScheduleController extends Controller
{
    public function index()
    {
        $schedules = CleaningSchedule::with('user1','user2')->where('monitoringDate','>=',Carbon::today())->paginate(CleaningSchedule::ITEMS_PER_PAGE);
        return view('users',['schedules'=> $schedules]);
    }

    public function userSchedule() {
        $schedules = CleaningSchedule::with('user1','user2')
            ->where('user1_id','=',Auth::user()->id)
            ->orWhere('user2_id','=',Auth::user()->id)
            ->get();
        return view('single_user_schedule',['schedules' => $schedules]);
    }

    public function scheduleHistory(){
        $schedules = CleaningSchedule::with('user1','user2')->where('monitoringDate','<',Carbon::today())->get();
        return view('schedule_history',['schedules'=> $schedules]);
    }


    public function populateData(): \Illuminate\Http\RedirectResponse
    {
        $allUsers = User::query()->all()->shuffle()->toArray(); // List of all users in random order
        $allUsers = [...$allUsers,...$allUsers];
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
        return redirect()->route('raspored');
    }

    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new ScheduleExport, 'Schedule.xlsx');
    }
}
