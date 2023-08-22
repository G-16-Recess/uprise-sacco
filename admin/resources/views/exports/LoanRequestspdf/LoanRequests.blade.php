<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOAN REQUESTS PDF</title>
    <style>
        #loans {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #loans td, #loans th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #loans tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #loans tr:hover {
            background-color: #ddd;
        }

        #loans th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>
    <h1>ALL LOAN REQUESTS TABLE</h1>
    <table id="loans">
        <tr>
            <th>Member ID</th>
            <th>Loan Application Number</th>
            <th>Name</th>
            <th>Email</th>
            <th>Amount Requested</th>
            <th>Status</th>
            <th>Period-In-Months</th>
        </tr>
        @if(count($LoanRequests) > 0)
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
        @else
            <tr>
                <td colspan='7'>No Loans requested</td>
            </tr>
        @endif
    </table>
</body>
</html>
