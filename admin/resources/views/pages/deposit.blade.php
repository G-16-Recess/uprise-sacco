@extends('layouts.app', ['activePage' => 'deposit', 'title' => 'uprise sacco | Deposits', 'navName' => 'Deposits', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header ">
                            <button type="button" class="btn btn-sm bg-warning btn-light"> Upload deposits</button>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Receipt no</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Member no</th>
                                </thead>
                                <tbody>
                                    @foreach ($deposits as $deposit)
                                        <tr>
                                            <td>{{$deposit['receipt_number']}}</td>
                                            <td>{{$deposit['amount']}}</td>
                                            <td>{{$deposit['date']}}</td>
                                            <td>{{$deposit['status']}}</td>
                                            <td>{{$deposit['member_number']}}</td>
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