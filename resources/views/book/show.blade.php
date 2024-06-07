@extends('layouts.main')

@section('container')
<div class="container">
    <div class="row my-3">
        <div class="col-lg-8">
            <a href="/books" class="btn btn-primary"><i class="bi bi-arrow-return-left"></i> Back</a>
            <a href="/books/{{ $book->id }}/edit" class="btn btn-warning"><i class="bi bi-pencil-square"></i> Edit</a>
            <form action="/books/{{ $book->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button class="btn btn-danger" onclick="return confirm('Are you sure')"><i class="bi bi-trash5"></i>
                    Delete</button>
            </form>

            <h1 class="mb-3 mt-3">Title : {{ $book->title }}</h1>

            <h5 class="mb-2 mt-3">ISBN : {{ $book->isbn }}</h5>
            <h5 class="mb-2">Author : {{ $book->author }}</h5>
            <h5 class="mb-2">Publisher : {{ $book->publisher }}</h5>
            <h5 class="mb-2">Released Date : {{ $book->release_date }}</h5>
            <h5 class="mb-2">Category : {{ $book->category->title }}</h5>
            <h5 class="mb-2">Stock : {{ $book->stock }}</h5>
            <h5 class="mb-2">Available Stock : {{ $book->available_stock }}</h5>
        </div>
    </div>
</div>

{{-- Content placeholder here --}}
<form action="{{ route('books.addChild', ['book' => $book->id]) }}" method="POST">
    @csrf
    <div class="w-25 ml-auto text-right">
        <div class="form-group">
            <label for="numberOfBooks" class="form-label text-right">Number of books: </label>
            <input type="number" class="form-control @error('numberOfBooks') is-invalid @enderror" id="numberOfBooks"
                name="numberOfBooks" required value="{{ old('numberOfBooks', 1) }}">
            @error('numberOfBooks')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div>
            <button type="submit" class="btn btn-primary ml-auto" data-id={{ $book->id }}>
                <i class="fa-regular fa-plus"></i>
                Add new book</button>
        </div>
    </div>
</form>



{{-- Flash message --}}
@if(session()->has('success'))
<div class="alert alert-success col-lg-12" role="alert">
    {{ session('success') }}
</div>
@endif

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
                        <th>#</th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>ID</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($book_childrens as $children)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $children->id }}</td>
                        <td>{{ $children->status }}</td>
                        <td>
                            <form action="/books/{{ $book->id }}/delete" method="post" class="d-inline">
                                @csrf
                                {{-- <input type="hidden" name="parent_id" value="{{ $->id }}"> --}}
                                <input type="hidden" name="child_id" value="{{ $children->id }}">
                                <button type="submit" class="btn btn-danger border-0"
                                    onclick="return confirm('Are you sure')"><i class="bi bi-trash3"></i>
                                    Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection