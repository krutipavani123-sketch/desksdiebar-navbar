
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>
 {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
<script>
    tailwind.config = {
        corePlugins: {
            preflight: false, // STOPS Tailwind from breaking Bootstrap styles
        }
    }
</script>
    <style>
        body {
            background: #f4f6fb;
        }

        .app-container {
            padding: 25px;
        }

        .app-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            padding: 20px;
        }

        .app-title {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ url('list') }}">
           Desk System
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
            aria-controls="navbarContent"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('list') }}">Home</a>
                </li>

     {{-- @can('create task') --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.list') }}">Add Role</a>
                </li>
     {{-- @endcan  --}}
 
 <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissions.permissionlist') }}">Add Permissions</a>
                </li>

 {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissions.permissionadd') }}">Add Permissions</a>
                </li> --}}
{{--
@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage users'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.list') }}">Users</a>
                </li>
@endif

@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage roles'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles/list') }}">Roles</a>
                </li>
               
@endif --}}
            </ul>

            <!-- Right Side Icons -->
            <div class="d-flex gap-3 mt-3 mt-lg-0">
                <a href="{{ url('profile') }}">
                    <i class="bi bi-person-circle"></i>
                </a>

                <a href="{{ url('logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container app-container">
    @yield('main')
</div>



</body>
</html> 


































{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>

    <style>
        body {
            background: #f4f6fb;
        }

        .app-container {
            padding: 25px;
        }

        .app-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            padding: 20px;
        }

        .app-title {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
          .sidebar {
            min-width: 240px;
            max-width: 240px;
            background: #fff;
            min-height: calc(100vh - 56px); /* Full height minus navbar */
            border-right: 1px solid #e3e6f0;
        }

        .sidebar .nav-link {
            color: #333;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sidebar .nav-link:hover {
            background: #f8f9fc;
            color: #0d6efd;
        }

        .sidebar .nav-link.active {
            background: #e9ecef;
            font-weight: 600;
        }

        /* Layout Wrapper */
.main-wrapper {
    display: flex;
    transition: all 0.3s;
}

/* Sidebar Toggle Logic */
#sidebar.collapsed {
    margin-left: -240px;
}

.content-area {
    flex-grow: 1;
    transition: all 0.3s;
}


    </style>
</head>

<body>

<!-- NAVBAR -->
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ url('list') }}">
           Desk System
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
            aria-controls="navbarContent"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto">

                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('list') }}">Home</a>
                </li> --}}

    {{-- @can('create task') --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles/addrole') }}">Add User</a>
                </li> --}}
    {{-- @endcan --}}
{{-- 

@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage users'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.list') }}">Users</a>
                </li>
@endif

@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage roles'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles/list') }}">Roles</a>
                </li>
               
@endif --}}
            {{-- </ul>

            <!-- Right Side Icons -->
            <div class="d-flex gap-3 mt-3 mt-lg-0">
                <a href="{{ url('profile') }}">
                    <i class="bi bi-person-circle"></i>
                </a>

                <a href="{{ url('logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
</nav>
<div class="main-wrapper">
    <!-- SIDEBAR -->
    <nav id="sidebar" class="sidebar">
        <div class="nav flex-column">
            <a href="#" class="nav-link active"><i class="bi bi-house"></i> Dashboard</a>
            <a href="#" class="nav-link"><i class="bi bi-person"></i> Users</a>
            <a href="#" class="nav-link"><i class="bi bi-gear"></i> Settings</a>
        </div>
    </nav>

    <!-- PAGE CONTENT -->
    <div class="content-area">
        <div class="app-container">
            <div class="app-card">
                <h2 class="app-title">@yield('title')</h2>
                <!-- Content goes here -->
            </div>
        </div>
    </div>
</div>
<!-- CONTENT -->
<div class="container app-container">
    @yield('main')
</div>



</body>
</html> --}}
 

















{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.css">

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-table@1.27.3/dist/bootstrap-table.min.js"></script>

    <style>
        body {
            background: #f4f6fb;
        }

        .app-container {
            padding: 25px;
        }

        .app-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            padding: 20px;
        }

        .app-title {
            font-weight: 700;
            margin-bottom: 15px;
        }

        .navbar {
            background: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ url('list') }}">
           Desk System
        </a>

        <!-- Mobile Menu Button -->
        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarContent"
            aria-controls="navbarContent"
            aria-expanded="false"
            aria-label="Toggle navigation">

            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('list') }}">Home</a>
                </li>

    {{-- @can('create task') --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles/addrole') }}">Add User</a>
                </li> --}}
    {{-- @endcan --}}
{{-- 

@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage users'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.list') }}">Users</a>
                </li>
@endif

@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage roles'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles/list') }}">Roles</a>
                </li>
               
@endif --}}
            {{-- </ul>

            <!-- Right Side Icons -->
            <div class="d-flex gap-3 mt-3 mt-lg-0">
                <a href="{{ url('profile') }}">
                    <i class="bi bi-person-circle"></i>
                </a>

                <a href="{{ url('logout') }}">
                    <i class="bi bi-box-arrow-right"></i>
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container app-container">
    @yield('main')
</div>



</body>
</html> --}} 