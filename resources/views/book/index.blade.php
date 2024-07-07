@extends('layouts.main')

@section('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
{{-- CSS for this page --}}
<style>
    #borrowModal table td {
        border: none;
    }
</style>
@endsection

@section('container')
<h5>Book</h5>

{{-- Content placeholder here --}}
@if (Auth::user()->role->title == 'admin')
<div class="row justify-content-end">
    <a href="{{ route('generateBookReport') }}" class="btn btn-primary mb-3"><i class="fa-regular fa-plus"></i> Generate Report</a>
</div>
@endif

{{-- Content placeholder here --}}
@if (in_array($role, array('librarian', 'admin')))
<div class="row justify-content-end">
    <a href="{{ route('books.create') }}" class="btn btn-info mb-3"><i class="fa-regular fa-plus"></i> Add new
        book</a>
</div>
@endif

{{-- Flash messages --}}
<div>
    @if ($errors->any())
    <div class="alert alert-danger col-lg-12" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @session('success')
    <div class="alert alert-success col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession

    @session('error')
    <div class="alert alert-danger col-lg-12" role="alert">
        {{ $value }}
    </div>
    @endsession
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">View Books</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="bookTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>ISBN</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Release Date</th>
                        <th>Stock</th>
                        <th>Available Stock</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Title</th>
                        <th>ISBN</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Release Date</th>
                        <th>Stock</th>
                        <th>Available Stock</th>
                        <th>Category</th>
                        <th>Action</th>
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
                        <td>{{ $book->category->title }}</td>
                        <td>
                            {{-- Action button for librarian and admin --}}
                            @if (in_array($role, array('librarian', 'admin')))
                            <div class="d-inline-flex flex-wrap" style="gap: 0.25rem">
                                <div class="flex-grow-1">
                                    <a href="{{ route('books.show', ['book' => $book->id]) }}"
                                        class="btn btn-primary"><i class="bi bi-eye"></i>
                                        Detail</span></a>
                                </div>
                                <div class="flex-grow-1">
                                    <a href="{{ route('books.edit', ['book' => $book->id]) }}"
                                        class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</span></a>
                                </div>
                                <div class="flex-grow-1">
                                    <form action="{{ route('books.destroy', ['book' => $book->id]) }}" method="POST"
                                        class="d-inline">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger" onclick="return confirm('Are you sure')"><i
                                                class="bi bi-trash3"></i> Delete</button>
                                    </form>
                                </div>
                            </div>
                            {{-- Action button for student --}}
                            @elseif ($book->available_stock > 0)
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#borrowModal"
                                data-book="{{ $book }}">
                                <i class="fa-regular fa-bookmark"></i> Borrow
                            </button>

                            {{-- Borrow modal --}}
                            <div class="modal fade" id="borrowModal" tabindex="-1" aria-labelledby="borrowModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Book Info</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>You will be borrowing book with:</p>
                                            <table>
                                                <tbody>
                                                    <tr>
                                                        <td>Title: </td>
                                                        <td class="infos" data-content="title"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Author: </td>
                                                        <td class="infos" data-content="author"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Publisher: </td>
                                                        <td class="infos" data-content="publisher"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <form action="{{route('borrow.post')}}" method="POST">
                                                @csrf
                                                <input type="hidden" name="bookId" value="">
                                                <button type="submit" class="btn btn-primary">Add</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <p>Not available</p>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<!-- Page level plugins -->
<script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script type="text/javascript">
    $('document').ready(function() {
        $('#bookTable').DataTable();

        // Handle modal open
        $('#borrowModal').on('show.bs.modal', function (event) {
            console.log('aksnjkdabnsd');
            var button = $(event.relatedTarget); // Button that triggered the modal
            var book = button.data('book');
            console.log(book);

            $(this).find('form input[name=bookId]').val(book.id)
            
            $(this).find('.infos').each((index, element) => {
                var content = $(element).data('content');
                console.log(content);
                $(element).text(book[content]);
            });
        });
    });
</script>
@endsection