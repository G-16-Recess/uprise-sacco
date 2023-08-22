<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOANS PDF</title>
    <style>
        #loan {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #loan td, #loan th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #loan tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #loan tr:hover {
            background-color: #ddd;
        }

        #loan th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>
    <h1>ALL LOAN TABLE</h1>
    <table id="loan">
        <tr>
            <th>Application ID</th>
            <th>Member ID</th>
            <th>Status</th>
            <th>Due_Date</th>
        </tr>
        @if(count($Loans) > 0)
            @foreach($Loans as $Loan)
                <tr>
                        <td>{{$Loan->Applicationid}}</td>
                        <td>{{$Loan->memberid}}</td>
                        <td>{{$Loan->status}}</td>
                        <td>{{$Loan->due_date}}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan='5'>No Loans given out</td>
            </tr>
        @endif
    </table>
</body>
</html>
