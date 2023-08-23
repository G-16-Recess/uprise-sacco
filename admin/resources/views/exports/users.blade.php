@extends('layouts.app', ['activePage' => 'table', 'title' => 'Light Bootstrap Dashboard Laravel by Creative Tim & UPDIVISION', 'navName' => 'Table List', 'activeButton' => 'laravel'])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card strpied-tabled-with-hover">
                    <div class="card-header d-flex justify-content-between align-items-center">
                    <img src="{{ asset('photos/logo-color.png') }}" alt="My Image" class="img-fluid" style="max-width: 50px; height: auto;">

<!-- 
                        //<img src="{{ asset('photos/logo-color.png') }}" alt="My Image"> -->
                        <h4 class="card-title">TABLE SHOWING DETAILS OF EACH MEMBER</h4>
                        <div>
                            <a id="DownloadPDFButton" class="btn btn-success ml-2" href="/export_user_pdf">Export PDF</a>
                        </div>
                    </div>
                    <div class="card-body table-full-width table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Member ID</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Email</th>
                                    <th>PhoneNumber</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->memberid}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->username}}</td>
                                    <td>{{$user->password}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->phoneNumber}}</td>
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

