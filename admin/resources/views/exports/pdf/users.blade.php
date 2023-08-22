<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>USERS PDF</title>
    <style>
        #members {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #members td, #members th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #members tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #members tr:hover {
            background-color: #ddd;
        }

        #members th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
        }
    </style>
</head>
<body>
<h1>ALL MEMBERS TABLE</h1>
<table id="members">
    <tr>
        
    </tr>
    @if(count($users) > 0)
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
    @else
        <tr>
            <td colspan='3'>No member found</td>
        </tr>
    @endif
</table>
</body>
</html>
