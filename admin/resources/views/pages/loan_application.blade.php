@extends('layouts.app', ['activePage' => 'loan_application', 'title' => 'uprise sacco | Loan Applications', 'navName' => 'Loan applications', 'activeButton' => 'laravel'])

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
                                    <th>Application number</th>
                                    <th>Member number</th>
                                    <th>Amount</th>
                                    <th>Amount Granted</th>
                                    <th>Repayment period</th>
                                 
                                </thead>
                                <tbody>
                                    @foreach ($members as $member)
                                        <tr>
                                            <td>{{$loan_application['application_number']}}</td>
                                            <td>{{$loan_application['member_number']}}</td>
                                            <td>{{$loan_application['amount']}}</td>
                                            <td class="amount_granted">{{$loan_application['amount_granted']}}</td>
                                            <td>{{$loan_application['repayment_period']}}</td>
                                   
                                            <td>
                                                <button class="btn btn-success btn-sm mx-2 edit-btn" data-toggle="modal" data-target="#editModal" data-application-number="{{$loan_application['application_number']}}">Edit</button>
                                                <button class="btn btn-success btn-sm approve-btn" data-application-number="{{$loan_application['application_number']}}">Approve</button>
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