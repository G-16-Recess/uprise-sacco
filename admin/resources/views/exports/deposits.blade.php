@extends('layouts.app', ['activePage' => 'table', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <img src="{{ asset('photos/logo-color.png') }}" alt="My Image" class="img-fluid" style="max-width: 50px; height: auto;">
                        <h4 class="card-title">TABLE SHOWING DEPOSIT DETAILS OF EACH MEMBER</h4>
                        <div>
                            <a id="DownloadPDFButton" class="btn btn-success ml-2" href="/export_deposit_pdf">Export DepositsPDF</a>
                           <button id="viewPDFButton" class="btn btn-primary ml-2">View PDF</button>
                        </div>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Member ID</th>
                                    <th>ReceiptNo</th>
                                    <th>Amount</th>
                                    <th>Date_Deposited</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($deposits as $deposit)
                                <tr>
                                    <td>{{$deposit->memberid}}</td>
                                    <td>{{$deposit->receiptno}}</td>
                                    <td>{{$deposit->amount}}</td>
                                    <td>{{$deposit->date_Deposited}}</td>
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

