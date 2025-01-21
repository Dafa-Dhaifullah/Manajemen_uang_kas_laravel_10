<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen uang kas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 48px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            transition: all 0.3s;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 48px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar.collapsed {
            margin-left: -250px;
        }
        #content {
        margin-left: 250px;
        width: calc(100% - 250px);
        transition: margin-left 0.3s ease, width 0.3s ease; 
    }

    #content.expanded {
        margin-left: 0;
        width: 100%;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark  fixed-top">
        <div class="container-fluid">
            <button id="sidebarToggle" class="btn btn-dark">
                <i class="bi bi-list"></i>
            </button>
            <div class="dropdown">
                <button class="btn btn-dark dropdown-toggle" type="button" id="profileDropdown" data-bs-toggle="dropdown">
                    {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="{{ route('profile') }}">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column ">
                        <li class="nav-item ">
                            <a class="nav-link text-white {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }} ">
                                <i class="bi bi-speedometer2 "></i>&nbsp; Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white{{ Request::is('students*') ? 'active' : '' }}" href="{{ route('students.index') }}">
                                <i class="bi bi-people"></i>&nbsp; Siswa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white{{ Request::is('payments*') ? 'active' : '' }}" href="{{ route('payments.index') }}">
                                <i class="bi bi-cash"></i>&nbsp; Uang Kas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white{{ Request::is('expenses*') ? 'active' : '' }}" href="{{ route('expenses.index') }}">
                            <i class="bi bi-credit-card"></i>&nbsp; Pengeluaran
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link text-white{{ Request::is('reports*') ? 'active' : '' }}" href="{{ route('reports.index') }}">
                                <i class="bi bi-file-text"></i>&nbsp; Laporan
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main id="content" class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('collapsed');
            document.getElementById('content').classList.toggle('expanded');
        });
    </script>
    @stack('scripts')
</body>
</html>
                                