@extends('layouts.app', ['activePage' => 'member', 'title' => 'uprise sacco | Members', 'navName' => 'Members', 'activeButton' => 'laravel'])

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
                        <div class="card-header d-flex">
                            <button type="button" class="btn btn-sm bg-warning" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="bi bi-filetype-csv"> </i>Upload members</button> 
                            <a id="DownloadPDFButton" class="btn btn-success ml-2 btn-sm" href="/export_user_pdf"><i class="bi bi-file-earmark-pdf-fill"> </i>Export PDF</a>
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
                                            <td>{{$member['member_number']}}</td>
                                            <td>{{$member['username']}}</td>
                                            <td>{{$member['phone_number']}}</td>
                                            <td>{{$member['account_balance']}}</td>
                                            <td>{{$member['loan_balance']}}</td>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add members</h5>
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