<!DOCTYPE html>
<html>

<head>
    <title>Library Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .report-container {
            width: 100%;
            margin: 0 auto;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .section-content {
            font-size: 14px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <div class="section-title">Generated on : {{ $date }}</div>
        <div class="section">
            <div class="section-title">Book Borrowings Log</div>
            <div class="section-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Student</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowingLog as $log)
                        <tr>
                            <td>{{ $log->updated_at }}</td>
                            <td>{{ $log->status }}</td>
                            <td>{{ $log->book->id }}</td>
                            <td>{{ $log->book->parent->title }}</td>
                            <td>{{ $log->user->fullname }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>