<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOAN REQUESTS PDF</title>
    <style>
        #repayments {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #repayments td, #repayments th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #repayments tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #repayments tr:hover {
            background-color: #ddd;
        }

        #repayments th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>
    <h1>ALL LOAN REPAYMENTS TABLE</h1>
    <table id="repayments">
        <tr>
            <th>Member ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>LoanBalance</th>

        </tr>
        @if(count($repayments) > 0)
            @foreach($repayments as $repayment)
                <tr>
                    <td>{{$repayment->memberid}}</td>
                    <td>{{$repayment->Name}}</td>
                    <td>{{$repayment->Email}}</td>
                    <td>{{$repayment->LoanBalance}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan='4'>No </td>
            </tr>
        @endif
    </table>
</body>
</html>
