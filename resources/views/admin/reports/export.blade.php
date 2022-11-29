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
                <th>File Name</th>
                <th>File Type</th>
                <th>Uploaded Date</th>
                <th>Status</th>
                <th>Supervisor</th>
                <th>Admin</th>
            </tr>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item['user'] }}</td>
                    <td>{{ $item['email'] }}</td>
                    <td>{{ $item['mobile_number'] }}</td>
                    <td>{{ $item['file_name'] }}</td>
                    <td>{{ $item['file_type'] }}</td>
                    <td>{{ $item['created_at'] }}</td>
                    <td>{{ $item['status'] }}</td>
                    <td>{{ $item['supervisor'] }}</td>
                    <td>{{ $item['admin'] }}</td>
                </tr>
            @endforeach
        </thead>
    </table>
</body>
</html>
                