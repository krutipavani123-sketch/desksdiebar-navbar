 {{-- @can('manage team') --}}
 
 @extends('layout')
@section('title', 'Team List')




@section('header')
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Team') }}
        </h2>
    </x-slot>

@endsection
@section('main')
   

<style>
body {
    background: #f4f6fb;
}

.page-wrapper {
    padding: 25px;
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

/* CHECKBOX */
input[type="checkbox"] {
    transform: scale(1.2);
}
</style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">



   @include('message')
            {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

       
             <div class="p-2 text-gray-900">

                <h2>Team List</h2>

                @can('create team')
<div class="mb-4 d-flex justify-content-end">

    <button type="button" 
            onclick="window.location.href='{{ route('team.create') }}'" 
            class="btn btn-primary btn-sm px-4 py-2 fw-semibold shadow-sm">
         Create Team
    </button>
</div>
@endcan --}}

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
        <h2><i class="bi bi-diagram-3-fill">Team List</i></h2>

        <div class="d-flex gap-2">

          
            <a href="{{ route('team.create') }}"
               class="btn btn-primary btn-modern">
                +  Create Team
            </a>
          

          

        </div>
    </div>
</div>


    <thead class="table-dark">
        <tr class="border-b">
            <th class="px-6 py-3 text-left" width="60"  data-sortable="true">No</th>
            <th class="px-6 py-3 text-left">Team Name</th>
            <th class="px-6 py-3 text-left">Team Leader</th>
            <th class="px-6 py-3 text-left">Team Member Name</th> 

                        <th class="px-6 py-3 text-left">Agent</th>
<th class="px-6 py-3 text-left">Team Category</th>
            <th class="px-6 py-3 text-left">Action</th>
        </tr>
    </thead>

  <tbody class="bg-white">
    @foreach($teams as $team)
    <tr>
        <td class="px-6 py-3 text-left">{{ $team->id }}</td>
        <td class="px-6 py-3 text-left">{{ $team->teamName }}</td>
       <td class="px-6 py-3 text-left">
            @if($team->leader)            {{-- leader model method name  --}}
                {{ $team->leader->name }}
            @else
                <span style="color: #999; font-style: italic;">No Leader Assigned</span>
            @endif
        </td>
        <td class="px-6 py-3 text-left">
            @if($team->users->isNotEmpty())
                {{ $team->users->pluck('name')->implode(', ') }}
            @else
                <span class="text-gray-400 italic">No members assigned</span>
            @endif
        </td>

       <td class="px-6 py-3 text-left">
          {{ $team->teamagents->pluck('name')->unique()->implode(', ') }}
   {{-- @foreach($team->agents as $agent)
   {{ $team->agents->pluck('name')->unique()->implode(' ') }}s --}}
{{-- @endforeach --}}
</td>

<td class="px-6 py-3 text-left">
            @if($team->category)
                {{ $team->category->name }}
            @else
                <span class="text-gray-400 italic">No Category assigned</span>
            @endif
        </td>

        <td class="d-flex gap-2 align-items-center">

    <!-- Edit -->
    <a href="{{route('team.edit', $team->id) }}"
       class="action-btn text-primary"
       title="Edit Ticket">

        <i class="bi bi-pencil-square"></i>
    </a>

    <!-- Delete -->
    <a href="{{ route('team.delete', $team->id) }}"
       class="action-btn text-danger"
       title="Delete Ticket"
       onclick="return confirm('Are you sure you want to delete this team?')">

        <i class="bi bi-trash-fill"></i>
    </a>
        {{-- @can('edit team')
        <td class="px-6 py-3 text-left">
            <a href="{{ route('team.edit', $team->id) }}">
                <i class="bi bi-pencil-square"></i>
            </a>
            {{-- @endcan
            @can('delete team') 
            <a href="{{ route('team.delete', $team->id) }}">
                <i class="bi bi-trash2-fill text-danger"></i>
            </a>
           --}}
        </td> 
          {{-- @endcan --}}
    </tr>
    @endforeach
</tbody>

             {{-- <td class="px-6 py-3 text-left">{{ $team->created_at->format('d M, Y') }}</td> --}}

             {{-- <td class="px-6 py-3 text-left">

                <a href="{{ route('team.edit', $team->id) }}">
    <i class="bi bi-pencil-square"></i>
</a>

                <a href="{{ route('team.delete',$team->id) }}" ><i class="bi bi-trash2-fill"></i></a>
            </td> 
        </tr>
        @endforeach
    </tbody> --}}
</table>


            </div>
        </div>
    </div>
    </div>


@endsection
{{-- 
@endcan --}}


    <style>
.bootstrap-table .fixed-table-container {
    border-bottom: 0 !important;
    height: auto !important;
}

.bootstrap-table .fixed-table-body {
    height: auto !important;
}

.bootstrap-table .fixed-table-pagination {
    margin-top: 5px !important;
}

.bootstrap-table {
    margin-bottom: 0 !important;
}
</style>