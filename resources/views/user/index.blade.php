@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add new user</a>
                <div class="m-3">
                </div>
                <table class="table table-striped">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            @if (Auth::user()->can('update', $user))
                                <td><a class="btn btn-warning" href="{{route('users.edit',$user->id)}}">Edit</a></td>
                            @endif
                            @can('delete', $user)
                                <td>
                                    <form method="post" action="{{route('users.destroy',$user->id)}}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </td>
                            @endcan
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
