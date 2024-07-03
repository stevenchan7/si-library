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
        <div class="section">
            <div class="section-title">Total Books</div>
            <div class="section-content">{{ $bookTotal }}</div>
        </div>

        <div class="section">
            <div class="section-title">Total Categories</div>
            <div class="section-content">{{ $categoryTotal }}</div>
        </div>

        <div class="section">
            <div class="section-title">Book Stock</div>
            <div class="section-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Available Stock</th>
                            <th>Unavailable Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $stock[0] }}</td>
                            <td>{{ $stock[1] }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <div class="section-title">Book Borrowings Per Month</div>
            <div class="section-content">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Borrowings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookBorrowingPerMonth as $record)
                        <tr>
                            <td>{{ $record->month }}</td>
                            <td>{{ $record->count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>