<x-layouts.layout>
    @section('title')
    <title>Djanbrary</title>
    @endsection

    @section('css')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    @endsection

    {{-- Flash messages --}}
    <div>
        {{-- validation errors --}}
        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        {{-- success --}}
        @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
        @endsession
        {{-- error --}}
        @session('error')
        <div class="alert alert-danger" role="alert">
            {{ $value }}
        </div>
        @endsession
    </div>

    {{-- Content placeholder here --}}
    @if (Auth::user()->role->title == 'admin')
    <div class="row justify-content-end">
        <a href="{{ route('generateLogReport') }}" class="btn btn-primary mb-3"><i class="fa-regular fa-plus"></i> Generate Report</a>
    </div>
    @endif
    {{-- <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        @if (Auth::user()->role->title == 'admin')
        <a href="{{ route('generateReport') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
        @endif
    </div> --}}

    {{-- Nav buttons --}}
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <button id="showPending" data-table="pendingBookTableResponsive"
                class="btn btn-link btn-table active">Pending</button>
        </li>
        <li class="nav-item">
            <button id="showReady" data-table="readyBookTableResponsive" class="btn btn-link btn-table">Ready</button>
        </li>
        <li class="nav-item">
            <button id="showTaken" data-table="takenBookTableResponsive" class="btn btn-link btn-table">Taken</button>
        </li>
        @if (in_array($role, array('librarian', 'admin')))
        <li class="nav-item">
            <button id="showReturned" data-table="returnedBookTableResponsive"
                class="btn btn-link btn-table">Returned</button>
        </li>
        <li class="nav-item">
            <button id="showCanceled" data-table="canceledBookTableResponsive"
                class="btn btn-link btn-table">Canceled</button>
        </li>
        <li class="nav-item">
            <button id="showRejected" data-table="rejectedBookTableResponsive"
                class="btn btn-link btn-table">Rejected</button>
        </li>
        @endif
    </ul>

    {{-- Table start --}}
    <div id="table-container">
        <div class="card shadow my-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Books</h6>
            </div>
            <div class="card-body">
                {{-- Pending book table --}}
                <div id="pendingBookTableResponsive" class="table-responsive">
                    <table class="table table-bordered" id="pendingBookTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($borrowings['pending'] as $borrowing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $borrowing->book->id }}</td>
                                <td>{{ $borrowing->book->parent->title }}</td>
                                <td>{{ $borrowing->user->fullname }}</td>
                                <td>{{ $borrowing->created_at->format('Y-m-d') }}</td>
                                <td>{{ $borrowing->return_deadline }}</td>
                                <td>
                                    @if (in_array($role, array('librarian', 'admin')))
                                    <div class="d-flex flex-wrap" style="gap: 0.25rem">
                                        <form action="{{ route('borrow.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                            <input type="hidden" name="status" value="ready">
                                            <button class="btn btn-primary d-flex align-items-center"
                                                style="gap: 0.25rem" onclick="return confirm('Are you sure?')">
                                                <i class="fa-regular fa-circle-check"></i>
                                                Ready</button>
                                        </form>
                                        <form action="{{ route('borrow.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                            <input type="hidden" name="status" value="rejected">
                                            <button class="btn btn-danger d-flex align-items-center"
                                                style="gap: 0.25rem" onclick="return confirm('Are you sure?')">
                                                <i class="fa-regular fa-circle-xmark"></i>
                                                Reject</button>
                                        </form>
                                    </div>
                                    @else
                                    <form action="{{ route('borrow.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                        <input type="hidden" name="status" value="canceled">
                                        <button class="btn btn-danger d-flex" style="gap: 0.25rem"
                                            onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                            Cancel</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Ready book table --}}
                <div id="readyBookTableResponsive" class="table-responsive" style="display:none">
                    <table class="table table-bordered" id="readyBookTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($borrowings['ready'] as $borrowing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $borrowing->book->id }}</td>
                                <td>{{ $borrowing->book->parent->title }}</td>
                                <td>{{ $borrowing->user->fullname }}</td>
                                <td>{{ $borrowing->created_at->format('Y-m-d') }}</td>
                                <td>{{ $borrowing->return_deadline }}</td>
                                <td>
                                    <div class="d-flex flex-wrap align-items-center" style="gap: 0.25rem">
                                        @if (in_array($role, array('librarian', 'admin')))
                                        <form action="{{ route('borrow.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                            <input type="hidden" name="status" value="taken">
                                            <button class="btn btn-primary d-flex" style="gap: 0.25rem"
                                                onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                                Taken</button>
                                        </form>
                                        @endif
                                        <form action="{{ route('borrow.update') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                            <input type="hidden" name="status" value="canceled">
                                            <button class="btn btn-danger d-flex" style="gap: 0.25rem"
                                                onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                                Cancel</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Taken book table --}}
                <div id="takenBookTableResponsive" class="table-responsive" style="display:none">
                    <table class="table table-bordered" id="takenBookTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                @if (in_array($role, array('librarian', 'admin')))
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                @if (in_array($role, array('librarian', 'admin')))
                                <th>Action</th>
                                @endif
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($borrowings['taken'] as $borrowing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $borrowing->book->id }}</td>
                                <td>{{ $borrowing->book->parent->title }}</td>
                                <td>{{ $borrowing->user->fullname }}</td>
                                <td>{{ $borrowing->created_at->format('Y-m-d') }}</td>
                                <td>{{ $borrowing->return_deadline }}</td>
                                @if (in_array($role, array('librarian', 'admin')))
                                <td>
                                    <form action="{{ route('borrow.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                        <input type="hidden" name="status" value="returned">
                                        <button class="btn btn-primary d-flex" style="gap: 0.25rem"
                                            onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                            Returned</button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (in_array($role, array('librarian', 'admin')))
                {{-- Returned book table --}}
                <div id="returnedBookTableResponsive" class="table-responsive" style="display:none">
                    <table class="table table-bordered" id="returnedBookTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($borrowings['returned'] as $borrowing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $borrowing->book->id }}</td>
                                <td>{{ $borrowing->book->parent->title }}</td>
                                <td>{{ $borrowing->user->fullname }}</td>
                                <td>{{ $borrowing->created_at->format('Y-m-d') }}</td>
                                <td>{{ $borrowing->return_deadline }}</td>
                                <td>
                                    <form action="{{ route('borrow.delete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                        <button class="btn btn-danger d-flex" style="gap: 0.25rem"
                                            onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                            Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Canceled book table --}}
                <div id="canceledBookTableResponsive" class="table-responsive" style="display:none">
                    <table class="table table-bordered" id="canceledBookTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($borrowings['canceled'] as $borrowing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $borrowing->book->id }}</td>
                                <td>{{ $borrowing->book->parent->title }}</td>
                                <td>{{ $borrowing->user->fullname }}</td>
                                <td>{{ $borrowing->created_at->format('Y-m-d') }}</td>
                                <td>{{ $borrowing->return_deadline }}</td>
                                <td>
                                    <form action="{{ route('borrow.delete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                        <button class="btn btn-danger d-flex" style="gap: 0.25rem"
                                            onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                            Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- Rejedted book table --}}
                <div id="rejectedBookTableResponsive" class="table-responsive" style="display:none">
                    <table class="table table-bordered" id="rejectedBookTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Book ID</th>
                                <th>Title</th>
                                <th>Student</th>
                                <th>Borrow date</th>
                                <th>Returned date</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($borrowings['rejected'] as $borrowing)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $borrowing->book->id }}</td>
                                <td>{{ $borrowing->book->parent->title }}</td>
                                <td>{{ $borrowing->user->fullname }}</td>
                                <td>{{ $borrowing->created_at->format('Y-m-d') }}</td>
                                <td>{{ $borrowing->return_deadline }}</td>
                                <td>
                                    <form action="{{ route('borrow.delete') }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="id" value="{{ $borrowing->id }}">
                                        <button class="btn btn-danger d-flex" style="gap: 0.25rem"
                                            onclick="return confirm('Are you sure?')"><i class="bi bi-trash3"></i>
                                            Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
    {{-- Table end --}}

    @section('script')
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
    <script type="text/javascript">
        $('document').ready(function() {
            var tableIds = [];

            // Get table ids
            $('.table-responsive').each(function() {
                tableIds.push($(this).attr('id'));
            });

            // Initialize DataTable
            $('.table').each(function() {
                $(this).DataTable();
            });

            // handle nav button click
            $('.btn-table').click(function() {
                // Hide table that is not clicked btn table
                var tableId = $(this).data('table');
                $('#' + tableId).show();

                tableIds.forEach(id => {
                    if (id !== tableId) {
                        $('#' + id).hide();
                    }
                });
            });
    });
    </script>
    @endsection
</x-layouts.layout>