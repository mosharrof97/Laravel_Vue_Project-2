<!DOCTYPE html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Test</title>
</head>

<body>
    <div class="container my-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Employee No</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Job Titel</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    {{-- {{ $key => $data }} --}}
                    <tr>
                        <td>{{ $data['rn'] }}</td>
                        <td>{{ $data['empno'] }}</td>
                        <td>{{ $data['ename'] }}</td>
                        <td>{{ $data['job'] }}</td>
                        <td>{{ $data['hiredate'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>
