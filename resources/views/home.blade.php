@extends('layouts.main')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @can('manage-administration')
                    <ul>
                        <li> <a href="{{route('users.memberlist')}}">Member List</a> </li>
                    </ul>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
