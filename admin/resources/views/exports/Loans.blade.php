@extends('layouts.app', ['activePage' => 'table', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <img src="{{ asset('photos/logo-color.png') }}" alt="My Image" class="img-fluid" style="max-width: 50px; height: auto;">
                        <h4 class="card-title">TABLE SHOWING LOANS</h4>
                        <div>
                            <a id="DownloadPDFButton" class="btn btn-success ml-2" href="/export_Loans_pdf">Export LoansPDF</a>
                        </div>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Application ID</th>
                                    <th>Member ID</th>
                                    <th>Status</th>
                                    <th>Due_Date</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach($Loans as $Loan)
                                <tr>
                                    <td>{{$Loan->Applicationid}}</td>
                                    <td>{{$Loan->memberid}}</td>
                                    <td>{{$Loan->status}}</td>
                                    <td>{{$Loan->due_date}}</td>
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

