@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="m-3">
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Datum</th>
                        <th>Dežurni 1</th>
                        <th>Dežurni 2</th>
                    </tr>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{$schedule->monitoringDate}}</td>
                            <td>{{$schedule->user1->name}}</td>
                            <td>{{$schedule->user2->name}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
