@extends('layouts.main')

@section('container')
    {{-- Content placeholder here --}}
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Release Date</th>
                            <th>Stock</th>
                            <th>Available Stock</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>ISBN</th>
                            <th>Author</th>
                            <th>Publisher</th>
                            <th>Release Date</th>
                            <th>Stock</th>
                            <th>Available Stock</th>
                            <th>Category</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->publisher }}</td>
                            <td>{{ $book->release_date }}</td>
                            <td>{{ $book->stock }}</td>
                            <td>{{ $book->available_stock }}</td>
                            <td>{{ $book->categor_id }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection