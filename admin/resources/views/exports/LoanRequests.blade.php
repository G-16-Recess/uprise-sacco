@extends('layouts.app', ['activePage' => 'table', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <img src="{{ asset('photos/logo-color.png') }}" alt="My Image" class="img-fluid" style="max-width: 50px; height: auto;">
                        <h4 class="card-title">TABLE SHOWING LOAN APPLICATION DETAILS OF EACH MEMBER</h4>
                        <div>
                            <a id="DownloadPDFButton" class="btn btn-success ml-2" href="/export_LoanRequest_pdf">Export LoanRequestsPDF</a>
                        </div>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>LoanApplicationNumber</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>AmountRequested</th>
                    <th>Status</th>
                    <th>Period_In_Months</th>
                </tr>
            </thead>
         <tbody>
      @foreach($LoanRequests as $LoanRequest)
            <tr>
                <td>{{$LoanRequest->memberid}}</td>
                <td>{{$LoanRequest->LoanApplicationNumber}}</td>
                <td>{{$LoanRequest->Name}}</td>
                <td>{{$LoanRequest->Email}}</td>
                <td>{{$LoanRequest->AmountRequested}}</td>
                <td>{{$LoanRequest->Status}}</td>
                <td>{{$LoanRequest->Period_In_Months}}</td>

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

