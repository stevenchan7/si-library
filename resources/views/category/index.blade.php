@extends('layouts.main')

@section('css')
<link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('container')
    <h5>Category</h5>

    <div class="row justify-content-end">
        <button id="newCategoryButton" type="button" class="btn btn-primary mb-3" data-toggle="modal"
            data-target="#category-modal">
            <i class="fa-regular fa-plus"></i> Add new category
        </button>
        <!-- Add category modal -->
        <div class="modal fade @if ($errors->any()) show @endif" id="category-modal" tabindex="-1" aria-labelledby="categoryModal" aria-hidden="true" @if ($errors->any()) style="display: block;" @endif>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add category</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="/categories" class="mx-auto">
                                    @csrf
                                    <div class="form-group">
                                        <label for="title">Category</label>
                                        <input id="title" type="text" name="title" class="form-control @error('title') is-invalid @enderror" required value="{{ old('title') }}">
                                        @error('title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary">Add category</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editCategoryForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="editTitle">Category</label>
                            <input id="editTitle" type="text" name="title" class="form-control @error('title') is-invalid @enderror" required>
                            <div class="invalid-feedback" id="editTitleError"></div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Update category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- Flash message --}}
    @if(session()->has('success'))
    <div class="alert alert-success col-lg-12" role="alert">
      {{ session('success') }}
    </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">View Categories</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="categoryTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->title }}</td>
                            <td>
                                <button type="button" id="editCategoryBtn" class="btn btn-warning edit-category" data-id="{{ $category->id }}" data-title="{{ $category->title }}">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                                <form action="/categories/{{ $category->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button class="btn btn-danger border-0" onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i> Delete</button>
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

@section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <script>
        //get prev category
        $(document).ready(function() {
            $('.edit-category').on('click', function() { // Corrected selector
                var categoryId = $(this).data('id');
                var categoryTitle = $(this).data('title'); // Get category title from the button

                $('#editCategoryModal').modal('show');
                $('#editCategoryForm').attr('action', '/categories/' + categoryId);
                $('#editTitle').val(categoryTitle);
            });
        });
    </script>
    @if ($errors->any())
    <script>
        $(document).ready(function() {

            @if (session()->get('edit'))
                $('#editCategoryModal').modal('show');
            @else
                $('#category-modal').modal('show');
            @endif
        });
    </script>
    @endif
@endsection

