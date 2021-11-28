@extends('layouts.app')
@section('content')

<div style="width: 800px; margin:0 auto;">
    <table class="table table-striped">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Name</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col">joined_date</th>
        </tr>
    </thead>
    <tbody>
    @foreach($members as $key => $member)
        <tr>
            <th scope="row">{{$key + 1}}</th>
            <td>{{$member->name}}</td>
            <td>{{$member->email}}</td>
            <td>{{$member->type}}</td>
            <td>{{$member->created_at}}</td>
        </tr>
    @endforeach
    </tbody>
    </table>
</div>

@endsection

