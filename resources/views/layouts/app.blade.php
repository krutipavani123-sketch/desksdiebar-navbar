<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

        <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            background:#f1f5f9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x:hidden;
        }

        /* SIDEBAR */

        .sidebar{
            width:260px;
            height:100vh;
            position:fixed;
            left:0;
            top:0;
            background:linear-gradient(180deg,#111827,#1f2937);
            color:white;
            overflow-y:auto;
            z-index:999;
            transition:0.3s;
            box-shadow:4px 0 20px rgba(0,0,0,0.1);
        }

        .sidebar-header{
            padding:24px 20px;
            border-bottom:1px solid rgba(255,255,255,0.08);
        }

        .brand{
            font-size:22px;
            font-weight:700;
            color:#fff;
        }

        .brand span{
            color:#60a5fa;
        }

        .sidebar-menu{
            padding:15px 10px;
        }

        .sidebar-menu a{
            display:flex;
            align-items:center;
            gap:12px;
            padding:13px 15px;
            color:#d1d5db;
            text-decoration:none;
            border-radius:12px;
            margin-bottom:8px;
            transition:0.25s;
            font-size:15px;
            font-weight:500;
        }

        .sidebar-menu a:hover{
            background:rgba(255,255,255,0.08);
            color:white;
            transform:translateX(4px);
        }

        .sidebar-menu a.active{
            background:linear-gradient(135deg,#2563eb,#3b82f6);
            color:white;
            box-shadow:0 8px 20px rgba(37,99,235,0.3);
        }

        .sidebar-menu i{
            font-size:18px;
        }

        /* CONTENT */

        .main-content{
            margin-left:260px;
            min-height:100vh;
            padding:25px;
        }

        /* TOPBAR */

        .topbar{
            background:white;
            border-radius:18px;
            padding:18px 24px;
            margin-bottom:25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0 5px 18px rgba(0,0,0,0.05);
        }

        .page-title{
            font-size:24px;
            font-weight:700;
            color:#111827;
        }

        .topbar-right{
            display:flex;
            align-items:center;
            gap:18px;
        }

        .icon-btn{
            position:relative;
            color:#374151;
            font-size:22px;
            text-decoration:none;
            transition:0.2s;
        }

        .icon-btn:hover{
            color:#2563eb;
            transform:translateY(-2px);
        }

        .notification-badge{
            position:absolute;
            top:-5px;
            right:-8px;
            background:#ef4444;
            color:white;
            font-size:11px;
            border-radius:50%;
            width:18px;
            height:18px;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        /* DROPDOWN */

        .dropdown-menu{
            border:none;
            border-radius:14px;
            box-shadow:0 10px 25px rgba(0,0,0,0.1);
            overflow:hidden;
            padding:8px;
        }

        .dropdown-item{
            border-radius:10px;
            padding:10px 12px;
            transition:0.2s;
        }

        .dropdown-item:hover{
            background:#eff6ff;
        }

        /* RESPONSIVE */

        @media(max-width:991px){

            .sidebar{
                width:80px;
            }

            .sidebar .brand,
            .sidebar-menu span{
                display:none;
            }

            .main-content{
                margin-left:80px;
            }

            .sidebar-menu a{
                justify-content:center;
            }
        }

        @media(max-width:768px){

            .sidebar{
                position:relative;
                width:100%;
                height:auto;
            }

            .main-content{
                margin-left:0;
            }

            .topbar{
                flex-direction:column;
                gap:15px;
                align-items:flex-start;
            }
        }
    </style>
</head>

<body>

@php
    $user = auth()->user();
@endphp

<!-- SIDEBAR (SAME FOR ALL PAGES) -->
@include('partials.sidebar')

<!-- MAIN CONTENT -->
<div class="main-content">
    
    <div class="topbar">
        <h5>@yield('title')</h5>
    </div>

    @yield('main')

</div>

</body>
</html>