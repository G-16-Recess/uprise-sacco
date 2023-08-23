@extends('layouts.app', ['activePage' => 'request', 'title' => 'uprise sacco | Requests', 'navName' => 'Requests', 'activeButton' => 'laravel'])

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
                                    <th>Ref No</th>
                                    <th>Category</th>
                                    <th>Receipt No</th>
                                    <th>Member No</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                        <tr>
                                            @php
                                                $createdAt = \Carbon\Carbon::parse($request->created_at);
                                                $currentDateTime = \Carbon\Carbon::now();
                                                $timeDifference = $currentDateTime->diffInHours($createdAt);
                                            @endphp

                                            @if ($timeDifference >= 5)
                                                <td><span class="text-danger fs-5">*</span>{{$request['reference_number']}}</td>
                                                <td>{{$request['category']}}</td>
                                                <td>{{$request['receipt_number']}}</td>
                                                <td>{{$request['member_number']}}</td>
                                                <td>{{$request['created_at']}}</td>
                                                <td>{{$request['status']}}</td>
                                            @else
                                                <td>{{$request['reference_number']}}</td>
                                                <td>{{$request['category']}}</td>
                                                <td>{{$request['receipt_number']}}</td>
                                                <td>{{$request['member_number']}}</td>
                                                <td>{{$request['created_at']}}</td>
                                                <td>{{$request['status']}}</td>
                                            @endif
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