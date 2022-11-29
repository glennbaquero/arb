<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>User</th>
                <th>Email</th>
                <th>Mobile #</th>
                <th>Storage Consumed</th>
            </tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['user'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['mobile_number'] }}</td>
                    <td>{{ $item['usage'] }}</td>
                </tr>
            @endforeach
        </thead>
    </table>
</body>
</html>
                