@extends('layouts.app', ['activePage' => 'member', 'title' => 'uprise sacco | Members', 'navName' => 'Members', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header d-flex">
                            <button type="button" class="btn btn-sm bg-warning btn-light"> Upload members</button> 
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>username</th>
                                    <th>phone number</th>
                                    <th>Acc. balance</th>
                                    <th>Loan Balance</th>
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{$member['id']}}</td>
                                            <td>{{$member['username']}}</td>
                                            <td>{{$member['phonenumber']}}</td>
                                            <td>{{$member['accountbalance']}}</td>
                                            <td>{{$member['loanbalance']}}</td>
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