<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DEPOSITS PDF</title>
    <style>
        #deposits {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #deposits td, #deposits th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #deposits tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #deposits tr:hover {
            background-color: #ddd;
        }

        #deposits th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>

<h1>ALL DEPOSITS TABLE</h1>

<table id="deposits">
<tr>
    <th>Member ID</th>
    <th>ReceiptNo</th>
    <th>Amount</th>
    <th>Date_Deposited</th>
 </tr>
 @if(count($deposits) > 0)
     @foreach($deposits as $deposit)
        <tr>
            <td>{{$deposit->memberid}}</td>
            <td>{{$deposit->receiptno}}</td>
            <td>{{$deposit->amount}}</td>
            <td>{{$deposit->date_Deposited}}</td> 
        </tr>
     @endforeach
 @else
        <tr>
            <td colspan='4'>No Deposits found</td>
        </tr>
 @endif
</table>
</body>
</html>
