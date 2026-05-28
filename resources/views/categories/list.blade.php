@extends('layout')
@section('title', 'Category List')

@section('main')
<style>
body {
    background: #f4f6fb;
}

.page-wrapper {
    padding: 25px;
}

/* CARD */
.card-box {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    padding: 20px;
}

/* HEADER */
.header-bar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
}

.header-bar h2 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
}

/* BUTTONS */
.btn-modern {
    border-radius: 10px;
    font-weight: 600;
    padding: 8px 14px;
    transition: 0.2s;
}

.btn-modern:hover {
    transform: translateY(-2px);
}

/* TABLE */
.table {
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
}

.table thead {
    background: #111827;
    color: #fff;
}

.table th {
    font-size: 13px;
    font-weight: 600;
    padding: 12px;
    white-space: nowrap;
}

.table td {
    font-size: 13px;
    padding: 12px;
    vertical-align: middle;
}

/* STATUS BADGES */
.badge {
    padding: 6px 10px;
    border-radius: 999px;
    font-size: 12px;
    font-weight: 600;
}

.badge.open { background:#fff3cd; color:#856404; }
.badge.closed { background:#d1e7dd; color:#0f5132; }
.badge.reopen { background:#cfe2ff; color:#084298; }

/* ACTION ICONS */
.action-icons a {
    margin-right: 10px;
    font-size: 16px;
    transition: 0.2s;
}

.action-icons a:hover {
    transform: scale(1.2);
}
.action-btn{
    width:32px;
    height:32px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:8px;
    background:#f8f9fa;
    transition:0.2s;
    font-size:16px;
    text-decoration:none;
}

.action-btn:hover{
    transform: translateY(-2px);
    background:#e9ecef;
}
/* CHECKBOX */
input[type="checkbox"] {
    transform: scale(1.2);
}
</style>
{{-- <div class="app-card">

    <div class="d-flex justify-content-between mb-3">
        <h4>Users List</h4>
         <button type="button" 
            onclick="window.location.href='{{ route('users.create') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Create USer
    </button>
    </div> --}}

    <table id="table"
           class="table table-bordered table-sm"
           data-toggle="table"
           data-pagination="true"
           data-page-size="5"
           data-side-pagination="client"
           data-height="auto"
            data-search="true"
           data-page-list="[5,10,25,50,100,200,All]">

<div class="card-box mb-3">
    <div class="header-bar">
     <h2><i class="bi bi-list-ul me-1"></i> Category List</h2>

        <div class="d-flex gap-2">

          
            <a href="{{ route('categories.create') }}"
               class="btn btn-primary btn-modern">
                +  Create Category
            </a>
        </div>
    </div>
</div>



        <thead class="table-dark">
            <tr> <!-- Fixed missing open row tag -->
                <th data-field="id" class="px-6 py-3 text-left" width="60"  data-sortable="true">No</th>
                <th data-field="name" class="px-6 py-3 text-left">Name</th>
                
                <th data-field="created" class="px-6 py-3 text-left">Created</th>
                <th data-field="action" class="px-6 py-3 text-left">Action</th>
            </tr>
        </thead>

        <tbody class="bg-white">
            @foreach($categories as $category)
            <tr>
                <td class="px-6 py-3 text-left">{{ $category->id }}</td>
                <td class="px-6 py-3 text-left">{{ $category->name }}</td>
                <td class="px-6 py-3 text-left">{{ $category->created_at->format('d M, Y') }}</td>

                   <td class="d-flex gap-2 align-items-center">

    <!-- Edit -->
    <a href="{{route('categories.edit', $category->id)}}"
       class="action-btn text-primary"
       title="Edit Category">

        <i class="bi bi-pencil-square"></i>
    </a>


    <a href="{{ route('categories.delete', $category->id) }}"
       class="action-btn text-danger"
       title="Delete Category"
       onclick="return confirm('Are you sure you want to delete this category?')">

        <i class="bi bi-trash-fill"></i>
    </a> 

             
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>


@endsection
