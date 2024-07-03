<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Djanbrary</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Menus
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#bookCollapse" aria-expanded="true"
            aria-controls="bookCollapse">
            <i class="bi bi-book"></i>
            <span>Books</span>
        </a>
        <div id="bookCollapse" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Book Actions:</h6>
                <a class="collapse-item" href="/books">View Books</a>
                @if (in_array(Auth::user()->role->title, array('librarian', 'admin')))
                <a class="collapse-item" href="/categories">View Categories</a>
                @endif
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{route('borrow.index')}}">
            <i class="fa-regular fa-bookmark"></i>
            <span>Borrowings</span>
        </a>
    </li>

    @if (in_array(Auth::user()->role->title, array('librarian', 'admin')))
        <li class="nav-item">
            <a class="nav-link" href="{{route('users')}}">
                <i class="bi bi-person"></i>
                <span>Users</span>
            </a>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

    <!-- Sidebar Message -->
    <div class="sidebar-card d-none d-lg-flex">
        {{-- Tenor gif --}}
        <div class="tenor-gif-embed" data-postid="6124504793129675429" data-share-method="host"
            data-aspect-ratio="1.33333" data-width="100%"><a
                href="https://tenor.com/view/shocked-face-black-meme-gif-6124504793129675429">Shocked Face Black
                Sticker</a>from <a href="https://tenor.com/search/shocked+face-stickers">Shocked Face Stickers</a></div>
        <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
        <p class="text-center mb-2">Aduh besok proposal</p>
    </div>

</ul>
<!-- End of Sidebar -->