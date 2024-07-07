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
                <div class="section-title">Books Log</div>
                <div class="section-title">Book Data:</div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Released Date</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $book->id }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->release_date }}</td>
                            <td>{{ $book->category->title }}</td>
                        </tr>
                    </tbody>
                </table>
                <br>
                <div class="section-content">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Book ID</th>
                                <th>Student</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($borrowings as $log)
                            <tr>
                                <td>{{ $log->updated_at }}</td>
                                <td>{{ $log->status }}</td>
                                <td>{{ $log->book->id }}</td>
                                <td>{{ $log->user->fullname }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Book Title</th>
                                <th>ISBN</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Available Stock</th>
                                <th>Children</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($books as $book)
                            <tr>
                                <td>{{ $book->id }}</td>
                                <td>{{ $book->title }}</td>
                                <td>{{ $book->isbn }}</td>
                                <td>{{ $book->category->title }}</td>
                                <td>{{ $book->stock }}</td>
                                <td>{{ $book->available_stock }}</td>
                                <td>
                                    @if($book->children->isNotEmpty())
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Book ID</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($book->children as $child)
                                                    <tr>
                                                        <td>{{ $child->id }}</td>
                                                        <td>{{ $child->status }}</td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @else
                                    No Children
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> --}}
                </div>
            </div>
    </div>
    </div>
</body>

</html>