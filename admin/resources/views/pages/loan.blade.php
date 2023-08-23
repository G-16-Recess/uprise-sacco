@extends('layouts.app', ['activePage' => 'loan', 'title' => 'uprise sacco | Loans', 'navName' => 'Loans', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card strpied-tabled-with-hover">
                        <div class="card-header d-flex">
                            <a id="DownloadPDFButton" class="btn btn-success ml-2 btn-sm" href="/export_user_pdf"><i class="bi bi-file-earmark-pdf-fill"> </i>Export PDF</a>
                        </div>
                        <div class="card-body table-full-width table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <th>ID</th>
                                    <th>Application Number</th>
                                    <th>Member Number</th>
                                    <th>Amount</th>
                                    <th>Due Date</th>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $loan)
                                        <tr>
                                            <td>{{$loan['id']}}</td>
                                            <td>{{$loan['application_number']}}</td>
                                            <td>{{$loan['member_number']}}</td>
                                            <td>{{$loan['amount']}}</td>
                                            <td>{{$loan['due_date']}}</td>
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