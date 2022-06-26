<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Exports\ScheduleExport;
use Maatwebsite\Excel\Facades\Excel;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function edit(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateScheduleRequest  $request
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }



    public function getDates($numOfUsers) {
        $numOfDays = ceil($numOfUsers/2)+1;
        $start_date = date("Y-m-d");

        $dateMonthYearArr = array();
        $start_dateTS = strtotime($start_date);
        $end_dateTS = $start_dateTS + (60*60*24)*$numOfDays;
        $data = [];

        for ($currentDateTS = $start_dateTS; $currentDateTS <= $end_dateTS; $currentDateTS += (60 * 60 * 24)) {
            $currentDateStr = date("Y-m-d H:i:s",$currentDateTS);
            $day = date('D', $currentDateTS);
            if($day !== 'Sat' && $day !== 'Sun') {
//                $dateMonthYearArr[] = $currentDateStr;
                $dateMonthYearArr = ['monitoringDate' => $currentDateStr];
                array_push($data,$dateMonthYearArr);
            }
        }
        return $data;
    }

    public function generateData() {
        $schedules = Schedule::with('users')->get();
        return view('users',['schedules'=> $schedules]);
    }

    public function populateData(){
        $allUsers = User::all()->shuffle(); // List of all users in random order
        $numOfUsers = count($allUsers);
        $dates = $this->getDates($numOfUsers);
        $i=0;
        foreach($dates as $date) {
            $s = Schedule::query()->create($date); // Schedule row that is created
            User::query()->where('id', $allUsers[$i]->id)->update(['schedule_id' => $s->id]);
            User::query()->where('id', $allUsers[$i+1]->id)->update(['schedule_id' => $s->id]);
            $i=$i+2;
        }
        return redirect()->route('raspored');
    }

    public function export()
    {
        return Excel::download(new ScheduleExport, 'Schedule.xlsx');
    }
}

