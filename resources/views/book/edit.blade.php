@extends('layouts.main')

@section('container')
    <h3 class="ml-2">Update book</h3>

    <div class="col-lg-6 ml-5">
        <form action="/books/{{ $book->id }}" method="post" class="mb-5">
          @method('put')
          @csrf
          <div class="mb-3">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title', $book->title) }}">
            @error('title')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
  
          <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" required value="{{ old('isbn', $book->isbn) }}">
            @error('isbn')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror

          </div>
          <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" required value="{{ old('author', $book->author) }}">
            @error('Author')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          
          <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" required value="{{ old('publisher', $book->publisher) }}">
            @error('publisher')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="release_date" class="form-label">Released Date</label>
            <input type="date" class="form-control col-lg-3 @error('release_date') is-invalid @enderror" id="release_date" name="release_date" required value="{{ old('release_date', $book->release_date) }}">
            @error('release_date')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" class="form-control col-lg-3 @error('stock') is-invalid @enderror" id="stock" name="stock" required value="{{ old('stock', $book->stock) }}">
            @error('stock')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control col-lg-3" name="category_id" id="category">
              @foreach($categories as $category)
                @if(old('category_id' , $book->category_id) == $category->id) 
                  <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                @else
                  <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary mb-2">Update Book</button>

          <div>
              <a href="/books" class="btn btn-danger mb-3">Return</a>
          </div>
        </div>
      </form>
@endsection