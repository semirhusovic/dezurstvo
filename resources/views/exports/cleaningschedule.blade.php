<table class="table table-striped">
    <tr>
        <th>Datum</th>
        <th>Dezurni 1</th>
        <th>Dezurni 2</th>
    </tr>
    @foreach($schedules as $schedule)
        <tr>
            <td>{{$schedule->monitoringDate}}</td>
            <td>{{$schedule->user1->name}}</td>
            <td>{{$schedule->user2->name}}</td>
        </tr>
    @endforeach
</table>
