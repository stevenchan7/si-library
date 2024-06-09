@extends('layouts.main')

@section('container')
    <h3 class="ml-2">Add book</h3>

    <div class="col-lg-6 ml-5">
        <form action="/books" method="post" class="mb-5">
          @csrf
          <div class="mb-3">
            <label for="title" class="form-label">Book Title</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" required autofocus value="{{ old('title') }}">
            @error('title')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>
  
          <div class="mb-3">
            <label for="isbn" class="form-label">ISBN</label>
            <input type="text" class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" required value="{{ old('isbn') }}">
            @error('isbn')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror

          </div>
          <div class="mb-3">
            <label for="author" class="form-label">Author</label>
            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" required value="{{ old('author') }}">
            @error('Author')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          
          <div class="mb-3">
            <label for="publisher" class="form-label">Publisher</label>
            <input type="text" class="form-control @error('publisher') is-invalid @enderror" id="publisher" name="publisher" required value="{{ old('publisher') }}">
            @error('publisher')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="release_date" class="form-label">Released Date</label>
            <input type="date" class="form-control col-lg-3 @error('release_date') is-invalid @enderror" id="release_date" name="release_date" required value="{{ old('release_date') }}">
            @error('release_date')
            <div class="invalid-feedback">
              {{ $message }}
            </div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control col-lg-4" name="category_id" id="category">
              @foreach($categories as $category)
                @if(old('category_id') == $category->id) 
                  <option value="{{ $category->id }}" selected>{{ $category->title }}</option>
                @else
                  <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endif
              @endforeach
            </select>
          </div>

          <button type="submit" class="btn btn-primary mb-2">Add Book</button>

          <div>
            <a href="/books" class="btn btn-danger mb-3">Return</a>
        </div>
        </div>
      </form>
@endsection