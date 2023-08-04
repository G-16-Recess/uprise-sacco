@extends('layouts.app', ['activePage' => 'request', 'title' => 'uprise sacco | Requests', 'navName' => 'Requests', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Salary</th>
                                    <th>Country</th>
                                    <th>City</th>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{$member['id']}}</td>
                                            <td>{{$member['username']}}</td>
                                            <td>{{$member['phonenumber']}}</td>
                                            <td>{{$member['accountbalance']}}</td>
                                            <td>{{$member['loanbalance']}}</td>
                                            <td>
                                                <button class="btn btn-success btn-sm mx-2">Edit</button>
                                                <button class="btn btn-success btn-sm">Approve</button>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection