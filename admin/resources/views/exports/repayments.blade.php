@extends('layouts.app', ['activePage' => 'table', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <img src="{{ asset('photos/logo-color.png') }}" alt="My Image" class="img-fluid" style="max-width: 50px; height: auto;">
                        <h4 class="card-title">TABLE SHOWING LOANS REPAYMENTS DETAILS OF EACH MEMBER</h4>
                        <div>
                            <a id="DownloadPDFButton" class="btn btn-success ml-2" href="/export_Repayments_pdf">Export RepaymentsPDF</a>
                        </div>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>LoanBalance</th>

                </tr>
            </thead>
         <tbody>
      @foreach($repayments as $repayment)
            <tr>
                <td>{{$repayment->memberid}}</td>
                <td>{{$repayment->Name}}</td>
                <td>{{$repayment->Email}}</td>
                <td>{{$repayment->LoanBalance}}</td>

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


