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
<h5>Users</h5>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editRoleForm" method="POST">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="form-group">
                            <h6 id="username">a</h6>
                            <label for="role_id">Role</label>
                            <select class="form-control col-lg mb-3" name="role_id" id="role_id">
                                <option value="1">Student</option>
                                <option value="2">Librarian</option>
                                <option value="3">Admin</option>
                          </select>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary mb-4">Edit Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
        <h6 class="m-0 font-weight-bold text-primary">View Users</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="bookTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->fullname }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->title }}</td>
                        <td>
                            <button type="button" id="editRoleBtn" class="btn btn-primary edit-role" data-userid="{{ $user->id }}" data-user="{{ $user->username }}" data-role="{{ $user->role->id }}">
                                <i class="bi bi-person-fill"></i> Change role
                            </button>
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
        $(document).ready(function() {
            $('.edit-role').on('click', function() { 
                var username = $(this).data('user');
                var userId = $(this).data('userid');
                var roleId = $(this).data('role');
                var username_string = "Username: " + username;

                $('#editRoleModal').modal('show');
                $('#username').text(username_string);
                $('#role_id').val(roleId);
                $('#editRoleForm').attr('action', '/users/' + userId);
            });
        });
</script>
@endsection