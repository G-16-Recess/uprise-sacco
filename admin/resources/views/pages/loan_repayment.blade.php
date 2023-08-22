@extends('layouts.app', ['activePage' => 'loan_repayment', 'title' => 'uprise sacco | Loan Repayments', 'navName' => 'Loan repayments', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card">
                            <div class="card-body table-full-width table-responsive">
                            <div class="card-header ">
                                <button type="button" class="btn btn-sm bg-warning btn-light" data-bs-toggle="modal" data-bs-target="#exampleModal"> Upload repayments</button>
                            </div>
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>Application Number</th>
                                    <th>Member Number</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </thead>
                                <tbody>
                                    @foreach ($repayments as $repayment)
                                        <tr>
                                            <td>{{$repayment['application_number']}}</td>
                                            <td>{{$repayment['member_number']}}</td>
                                            <td>{{$repayment['amount']}}</td>
                                            <td>{{$repayment['due_date']}}</td>
                                             <td>
                                                <button class="btn btn-success btn-sm mx-2 delete-btn" data-application-number="{{$repayment['application_number']}}">Delete</button>
                                               
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

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add deposits</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control form-control-sm border-0 outline-0" type="file" name="csv_file" id="csv_file">
                        </div>
                        <div class="mb-2">
                            <button type="reset" class="btn btn-secondary btn-sm">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Upload csv</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection