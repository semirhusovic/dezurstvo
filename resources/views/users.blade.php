@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="m-3">
                    {{--                    <a href="{{ route('kreiraj') }}" class="btn btn-primary">Kreiraj listu</a>--}}
                    <a href="{{ route('schedule-report') }}" class="btn btn-success">Export to excel</a>
                </div>
                <table class="table table-hover">
                    <tr>
                        <th>Datum</th>
                        <th>Dežurni 1</th>
                        <th>Dežurni 2</th>
                        <th>Status</th>
                    </tr>
                    @foreach($schedules as $schedule)
                        <tr>
                            <td>{{$schedule->monitoringDate}}</td>
                            <td>{{$schedule->user1->name}}</td>
                            <td>{{$schedule->user2->name}}</td>
                            <td>
                                @if ($schedule->isDishes && $schedule->isTrash )
                                    <i class="fa-solid fa-circle-check" style="color:green"></i>
                                @else
                                    <i class="fa-solid fa-circle-xmark" style="color:red"></i>
                                @endif
                            </td>
                        </tr>
                        @if ($schedule->monitoringDate === date('Y-m-d') && ($schedule->user1 == auth()->user() || $schedule->user2 == auth()->user()))
                            <tr>
                                <td colspan="4">
                                    <div class="d-flex justify-content-around">
                                        <div class="form-switch">
                                            <input class="form-check-input" type="checkbox" value="" id="isTrash" onchange="save({{$schedule->id}}, '{{@csrf_token()}}',this)" {{$schedule->isTrash ? 'checked' : ''}}>
                                            <label class="form-check-label" for="isTrash">
                                                Izbaceno smece
                                            </label>
                                        </div>
                                        <div class="form-switch">
                                            <input class="form-check-input" type="checkbox" value="" id="isDishes" onchange="save({{$schedule->id}}, '{{@csrf_token()}}',this)" {{$schedule->isDishes ? 'checked' : ''}}>
                                            <label class="form-check-label" for="isDishes">
                                                Oprani sudovi
                                            </label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </table>
                {{$schedules->links('pagination::bootstrap-4')}}
            </div>
        </div>
    </div>
@endsection

<script>
    function save(schedule_id,csrf_token,ch){
        let url = "/update-task";
        let data = {
            schedule_id : schedule_id,
            [ch.id] : Number(ch.checked)
        }
        fetch(url, { method: 'POST', body: JSON.stringify(data), headers: {
                'X-CSRF-TOKEN': csrf_token,
                'Content-Type' : 'application/json'
            } })
            .then(function (response) {
                return response.text();
            }).then(function (body) {
            console.log(body);
        });
    }
</script>
