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
            BlogApp
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

    @can('create task')
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('add-blog') }}">Add Blog</a>
                </li>
    @endcan


@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage users'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.list') }}">Users</a>
                </li>
@endif

@if(auth()->user()?->hasRole('admin') || auth()->user()?->can('manage roles'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('roles/list') }}">Roles</a>
                </li>
               
@endif
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